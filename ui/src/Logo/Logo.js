import "./Logo.css";

function Logo({ size }) {
  return (
    <div className={`logo ${size}`}>
      <span className="logo-e">E</span>
      <span>ye</span>
      <span className="logo-s">S</span>
      <span>mart</span>
    </div>
  );
}

export default Logo;
