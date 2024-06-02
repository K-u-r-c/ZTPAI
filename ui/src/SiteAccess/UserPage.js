import React, { useState, useEffect } from "react";
import "./UserPage.css";
import Sidebar from "../Sidebar/Sidebar";
import Header from "../Header/Header";
import axios from "axios";

function UserPage() {
  const [userData, setUserData] = useState({
    username: "",
    email: "",
    profile_picture_url: "",
  });

  const [formData, setFormData] = useState({
    password: "",
    confirmPassword: "",
    profilePictureURL: "",
  });

  useEffect(() => {
    const fetchUserData = async () => {
      const url = `${process.env.REACT_APP_API_URL}/api/user/me`;
      const token = localStorage.getItem("token");
      const response = await fetch(url, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      const userData = await response.json();
      setUserData(userData);
    };

    fetchUserData();
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();

    const url = `${process.env.REACT_APP_API_URL}/api/user/update_me`;
    const token = localStorage.getItem("token");

    axios({
      method: "POST",
      url: url,
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      data: JSON.stringify(formData),
    })
      .then((res) => res.data)
      .then((result) => {
        if (result.success) {
          localStorage.setItem("token", result.token);

          const passwordWarning = document.getElementById("password-warning");
          passwordWarning.style.display = "block";
          passwordWarning.style.color = "green";
          passwordWarning.innerHTML = "Password updated successfully!";
        }
      });
  };

  return (
    <div style={{ display: "flex" }}>
      <Sidebar />

      <div className="user-content">
        <Header pageTitle="User settings" />

        <div className="profile-container">
          <div className="profile-header">
            <img
              src={userData.profile_picture_url}
              alt="Profile Picture"
              width="200"
            />
            <h1>{userData.username}</h1>
          </div>

          <form
            onSubmit={handleSubmit}
            method="POST"
            encType="multipart/form-data"
          >
            <div className="form-field">
              <input
                onChange={(e) => {
                  setFormData({
                    ...formData,
                    profilePictureURL: e.target.files[0],
                  });
                }}
                type="file"
                name="profilePictureURL"
              />
              <br />
            </div>

            <div className="form-field">
              <label>Username:</label>
              <input
                type="text"
                className="username"
                name="username"
                placeholder={userData.username || "Username"}
                required
                disabled
              />
            </div>

            <div className="form-field">
              <label>E-mail:</label>
              <input
                type="email"
                id="email"
                name="email"
                placeholder={userData.email || "E-mail"}
                required
                disabled
              />
            </div>

            <div className="form-field">
              <label>New password:</label>
              <input
                onChange={(e) => {
                  setFormData({ ...formData, password: e.target.value });
                }}
                type="password"
                id="password"
                name="password"
              />
            </div>

            <div className="form-field">
              <label>Confirm password:</label>
              <input
                onChange={(e) => {
                  setFormData({ ...formData, confirmPassword: e.target.value });
                }}
                type="password"
                id="confirm-password"
                name="confirm-password"
              />
              <span
                id="password-warning"
                style={{ color: "red", display: "none" }}
              >
                Passwords do not match!
              </span>
            </div>

            <input
              type="hidden"
              name="id_user"
              value="<?php echo $user->getIdUser() ?>"
            />

            <div className="form-field">
              <input type="submit" value="Save" id="submit-button" />

              <a href="logout" className="logout-button">
                Logout
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}

export default UserPage;
