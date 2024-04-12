import React, { useState } from "react";
import "./UserPage.css";
import Sidebar from "../Sidebar/Sidebar";
import Header from "../Header/Header";

function UserPage() {
  return (
    <div style={{ display: "flex" }}>
      <Sidebar />

      <div className="user-content">
        <Header pageTitle="User settings" />

        <div className="profile-container">
          <div className="profile-header">
            <img src="" alt="Profile Picture" width="200" />
            <h1>Username</h1>
          </div>

          <form
            action="change_user_settings"
            method="POST"
            encType="multipart/form-data"
          >
            <div className="form-field">
              <label>Profile picture:</label>
              <input type="file" name="file" />
              <br />
            </div>

            <div className="form-field">
              <label>Username:</label>
              <input
                type="text"
                className="username"
                name="username"
                placeholder="Username"
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
                placeholder="Email"
                required
                disabled
              />
            </div>

            <div className="form-field">
              <label>New password:</label>
              <input type="password" id="password" name="password" />
            </div>

            <div className="form-field">
              <label>Confirm password:</label>
              <input
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
              <a className="logout-button">Logout</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}

export default UserPage;
