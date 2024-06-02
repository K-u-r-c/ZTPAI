import React, { useState, useEffect } from "react";
import "./Clock.css";
import Sidebar from "../Sidebar/Sidebar";
import Header from "../Header/Header";
import OrSeparator from "../OrSeparator/OrSeparator";

function formatTime(seconds) {
  const hours = Math.floor(seconds / 3600);
  const minutes = Math.floor((seconds % 3600) / 60);
  const remainingSeconds = seconds % 60;

  const paddedHours = String(hours).padStart(2, "0");
  const paddedMinutes = String(minutes).padStart(2, "0");
  const paddedSeconds = String(remainingSeconds).padStart(2, "0");

  return `${paddedHours}:${paddedMinutes}:${paddedSeconds}`;
}

function Clock() {
  const [seconds, setSeconds] = useState(0);
  const [isActive, setIsActive] = useState(false);
  const [intervalId, setIntervalId] = useState(null);

  function toggle() {
    setIsActive(!isActive);
  }

  function reset() {
    setSeconds(0);
    setIsActive(false);
    clearInterval(intervalId);
  }

  useEffect(() => {
    let id;
    if (isActive) {
      id = setInterval(() => {
        setSeconds((seconds) => seconds + 1);
        if (seconds % 60 === 0 && seconds !== 0) {
          alert("Time for exercise!");
        }
      }, 1000);
      setIntervalId(id);
    } else if (!isActive && seconds !== 0) {
      clearInterval(intervalId);
    }
    return () => clearInterval(id);
  }, [isActive, seconds]);

  return (
    <div style={{ display: "flex" }}>
      <Sidebar />

      <div className="clock-content">
        <Header pageTitle="Clock" />

        <div className="clock">
          <div className="row">
            <button
              className={`start-button button button-primary button-primary-${
                isActive ? "active" : "inactive"
              }`}
              onClick={toggle}
            >
              {isActive ? (
                <i class="bi bi-pause-fill"></i>
              ) : (
                <i class="bi bi-play-fill"></i>
              )}
            </button>
            <button className="reset-button button" onClick={reset}>
              <i class="bi bi-arrow-clockwise"></i>
            </button>
          </div>
          <div className="time">{formatTime(seconds)}</div>
        </div>

        <OrSeparator text={"PROGRESS"} />

        <div className="clock-info">
          {/* Here I want to display exercises */}
        </div>
      </div>
    </div>
  );
}

export default Clock;
