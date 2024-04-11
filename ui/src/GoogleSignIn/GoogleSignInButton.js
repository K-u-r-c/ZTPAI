import React from "react";
import "./GoogleSignInButton.css";

function GoogleSignInButton() {
  return (
    <a href="#" className="sign-in-google">
      <img src="images/google-icon.svg" className="sign-in-google-icon" />
      <div className="sign-in-google-text">Sign in with Google</div>
    </a>
  );
}

export default GoogleSignInButton;
