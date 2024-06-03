import { useState } from "react";
import "./Sidebar.css";
import Logo from "../Logo/Logo";
import { Link } from "react-router-dom";

function Sidebar() {
  const isMobile = window.innerWidth <= 768;
  const [isSidebarVisible, setSidebarVisible] = useState(!isMobile);

  const toggleLeftBarButton = () => {
    setSidebarVisible(!isSidebarVisible);
  };

  return (
    <div className="sidebar">
      <div className="left-bar-small">
        <i
          className="bi bi-list toggle-left-bar-button"
          style={{ fontSize: "2.6rem" }}
          onClick={toggleLeftBarButton}
        ></i>
        <a href="#" className="help-sidebar"></a>
        <a href="/user" className="user-sidebar"></a>
      </div>

      <div
        className={`left-bar-big ${isSidebarVisible ? "visible" : "hidden"}`}
      >
        <Logo size="small" />
        <div className="sidebar-links mt-4">
          <ul className="work-time-list">
            <p className="work-time-text">Work time:</p>
            <li>
              <div className="icon-text">
                <i className="bi bi-clock-fill"></i>
                <Link to="/clock">
                  <span>Clock</span>
                </Link>
              </div>
            </li>
          </ul>
          <ul className="forum-list">
            <p className="forum-text">Forum:</p>
            <li>
              <div className="icon-text">
                <i className="bi bi-people-fill"></i>
                <Link to="/forum">
                  <span>General</span>
                </Link>
              </div>
            </li>
            <li>
              <div className="icon-text">
                <i className="bi bi-person-check-fill"></i>
                <Link to="#">
                  <span>Experts</span>
                </Link>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  );
}

export default Sidebar;
