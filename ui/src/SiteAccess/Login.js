import React, { useState } from "react";
import "./Login.css";
import { Link } from "react-router-dom";
import Logo from "../Logo/Logo";
import GoogleSignInButton from "../GoogleSignIn/GoogleSignInButton";
import OrSeparator from "../OrSeparator/OrSeparator";
import MotivationText from "../MotivationText/MotivationText";
import InputField from "../FormFields/InputField";
import SubmitButton from "../FormFields/SubmitButton";

function Login() {
  const loginImageUrl = "images/login-image.jpg";

  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const url = `${process.env.REACT_APP_API_URL}/login`;
    fetch(url, { method: "POST" })
      .then((res) => res.json())
      .then((result) => {
        console.log(result);
      });
  };

  return (
    <div className="login-content">
      <div className="login-left-box">
        <Logo size="large" />
        <MotivationText text="Let's log in to your EyeSmart account" />
        <form className="login-form" onSubmit={handleSubmit}>
          {/* Email field */}
          <InputField
            type="text"
            name="email"
            placeholder="E-mail:"
            id="email"
            value={formData.email}
            ariaLabel="Email"
            ariaDescribedby="basic-addon1"
            icon="envelope-fill"
          />

          {/* Password field */}
          <InputField
            type="password"
            name="password"
            placeholder="Password:"
            id="password"
            value={formData.password}
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
