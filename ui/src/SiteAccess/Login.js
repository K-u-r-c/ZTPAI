import React, { useState } from "react";
import "./Login.css";
import { Link } from "react-router-dom";
import Logo from "../Logo/Logo";
import GoogleSignInButton from "../GoogleSignIn/GoogleSignInButton";
import OrSeparator from "../OrSeparator/OrSeparator";
import MotivationText from "../MotivationText/MotivationText";
import InputField from "../FormFields/InputField";
import SubmitButton from "../FormFields/SubmitButton";
import axios from "axios";

function Login() {
  const loginImageUrl = "images/login-image.jpg";

  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });

  const handleSubmit = async (e) => {
    e.preventDefault();

    const url = `${process.env.REACT_APP_API_URL}/login`;
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
          window.location.href = "/forum";
        } else {
          const passwordWarning = document.getElementById("password-warning");
          passwordWarning.style.display = "block";
          passwordWarning.style.color = "red";
          passwordWarning.innerHTML = result.message;
        }
      });
  };

  return (
    <div className="login-content">
      <div className="login-left-box">
        <Logo size="large" />
        <MotivationText text="Let's log in to your EyeSmart account" />
        <form className="login-form" onSubmit={handleSubmit} method="POST">
          {/* Email field */}
          <InputField
            onChange={(e) => {
              setFormData({ ...formData, email: e.target.value });
            }}
            type="text"
            name="email"
            placeholder="E-mail:"
            id="email"
            value=""
            ariaLabel="Email"
            ariaDescribedby="basic-addon1"
            icon="envelope-fill"
          />

          {/* Password field */}
          <InputField
            onChange={(e) => {
              setFormData({ ...formData, password: e.target.value });
            }}
            type="password"
            name="password"
            placeholder="Password:"
            id="password"
            value=""
            ariaLabel="Password"
            ariaDescribedby="basic-addon2"
            icon="lock-fill"
          />

          <SubmitButton
            text="Sign In"
            color="#fff"
            backgroundColor="#28a745"
            hoverBackgroundColor="#218838"
          />
          <p id="password-warning" style={{ display: "none" }}></p>
        </form>
        <a href="#" className="login-forgot-password">
          Forgot password ?
        </a>
        <OrSeparator />
        <GoogleSignInButton />
        <div className="login-register-block">
          <p className="login-register-text">Don't have an account?</p>
          <Link to="/register" className="login-register-button">
            Sign Up
          </Link>
        </div>
      </div>
      <div
        className="login-right-box"
        style={{ backgroundImage: `url(${loginImageUrl})` }}
      ></div>
    </div>
  );
}

export default Login;
