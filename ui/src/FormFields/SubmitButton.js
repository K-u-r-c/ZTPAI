import React from "react";
import "./SubmitButton.css";

const SubmitButton = ({
  text,
  color = "white", // default color
  backgroundColor = "blue", // default background color
  hoverBackgroundColor = "darkblue", // default hover background color
}) => {
  return (
    <button
      type="submit"
      className="btn btn-success submit-button"
      style={{
        "--btn-color": color,
        "--btn-bg-color": backgroundColor,
        "--btn-hover-bg-color": hoverBackgroundColor,
      }}
    >
      {text}
    </button>
  );
};

export default SubmitButton;
