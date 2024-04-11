import React, { useState } from "react";
import "./Register.css";
import Logo from "../Logo/Logo";
import GoogleSignInButton from "../GoogleSignIn/GoogleSignInButton";
import OrSeparator from "../OrSeparator/OrSeparator";
import MotivationText from "../MotivationText/MotivationText";
import InputField from "../FormFields/InputField";
import SubmitButton from "../FormFields/SubmitButton";

function Register() {
  const registerImageUrl = "images/register-image.jpg";

  return (
    <div className="register-content">
      <div className="register-right-box">
        <Logo size="large" />
        <MotivationText text="Let's create your EyeSmart account" />
        <form action="register" method="POST" className="register-form">
          {/* Email field */}
          <InputField
            type="text"
            name="email"
            placeholder="E-mail:"
            id="email"
            ariaLabel="Email"
            ariaDescribedby="basic-addon1"
            icon="envelope-fill"
          />

          {/* Username field */}
          <InputField
            type="text"
            name="username"
            placeholder="Username:"
            id="username"
            ariaLabel="Username"
            ariaDescribedby="basic-addon1"
            icon="person-fill"
          />

          {/* Password field */}
          <InputField
            type="password"
            name="password"
            placeholder="Password:"
            id="password"
            ariaLabel="Password"
            ariaDescribedby="basic-addon2"
            icon="lock-fill"
          />

          {/* Repeat Password field */}
          <InputField
            type="password"
            name="repeat-password"
            placeholder="Repeat password:"
            id="repeat-password"
            ariaLabel="Repeat password"
            ariaDescribedby="basic-addon2"
            icon="lock-fill"
          />

          <SubmitButton
            text="Sign Up"
            color="#fff"
            backgroundColor="#6FA3EF"
            hoverBackgroundColor="#558EE0"
          />
        </form>
        <div className="register-privacy-policy">
          <p className="register-privacy-policy-text">
            By proceeding with the registration procedure, you declare that you
            have read and agree with the{" "}
            <a href="#" className="register-privacy-policy-link">
              privacy policy.
            </a>
          </p>
        </div>
        <OrSeparator />
        <GoogleSignInButton />
        <div className="register-login-block">
          <p className="register-login-text">Already have an account? </p>
          <a href="login" className="register-login-button">
            Sign In
          </a>
        </div>
      </div>
      <div
        className="register-left-box"
        style={{ backgroundImage: `url(${registerImageUrl})` }}
      ></div>
    </div>
  );
}

export default Register;
