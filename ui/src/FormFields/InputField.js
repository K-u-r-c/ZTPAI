import React from "react";
import "./InputField.css";

function InputField({
  type,
  name,
  placeholder,
  id,
  ariaLabel,
  ariaDescribedby,
  icon,
}) {
  return (
    <div className="input-group mb-3">
      <div className="input-group-prepend">
        <span className="input-group-text" id={ariaDescribedby}>
          <i className={`bi bi-${icon}`}></i>
        </span>
      </div>
      <input
        type={type}
        name={name}
        placeholder={placeholder}
        required
        id={id}
        className="form-control"
        aria-label={ariaLabel}
        aria-describedby={ariaDescribedby}
      />
    </div>
  );
}

export default InputField;
