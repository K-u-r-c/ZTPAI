import "./Header.css";

function Header({ pageTitle }) {
  return (
    <div className="header">
      <p className="page-title">{pageTitle}</p>
    </div>
  );
}

export default Header;
