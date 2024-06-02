import React, { useState, useEffect } from "react";
import "./Clock.css";
import Sidebar from "../Sidebar/Sidebar";
import Header from "../Header/Header";
import OrSeparator from "../OrSeparator/OrSeparator";

function dateIntervalToSeconds(interval) {
  const regex =
    /P(?:(\d+)Y)?(?:(\d+)M)?(?:(\d+)D)?T(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/;
  const matches = interval.match(regex);

  if (!matches) {
    throw new Error("Invalid interval format");
  }

  const years = parseInt(matches[1] || 0, 10);
  const months = parseInt(matches[2] || 0, 10);
  const days = parseInt(matches[3] || 0, 10);
  const hours = parseInt(matches[4] || 0, 10);
  const minutes = parseInt(matches[5] || 0, 10);
  const seconds = parseInt(matches[6] || 0, 10);

  const totalSeconds =
    years * 365 * 24 * 60 * 60 +
    months * 30 * 24 * 60 * 60 +
    days * 24 * 60 * 60 +
    hours * 60 * 60 +
    minutes * 60 +
    seconds;

  return totalSeconds;
}

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
  const [notifications, setNotifications] = useState([]);

  async function toggle() {
    if (!isActive) {
      const url = `${process.env.REACT_APP_API_URL}/api/clock/start_session`;
      const token = localStorage.getItem("token");
      const response = await fetch(url, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      if (response.status === 200) {
        setIsActive(true);
        setSeconds(0);
      } else {
        console.log("Failed to start session");
      }
    } else {
      reset();
    }
  }

  const fetchNotifications = async () => {
    const url = `${process.env.REACT_APP_API_URL}/api/clock/get_notifications`;
    const token = localStorage.getItem("token");
    const response = await fetch(url, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    if (response.status === 401) {
      console.log("Unauthorized");
      window.location.href = "/login";
      return;
    }

    setNotifications(await response.json());
  };

  const fetchLastSession = async () => {
    const url = `${process.env.REACT_APP_API_URL}/api/clock/get_last_session`;
    const token = localStorage.getItem("token");
    const response = await fetch(url, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    if (response.status === 200) {
      const session = await response.json();
      const totalSeconds = dateIntervalToSeconds(session.totalTime);
      setSeconds(totalSeconds);
      fetchNotifications();
    } else {
      console.log("Failed to fetch last session");
    }
  };

  async function reset() {
    const url = `${process.env.REACT_APP_API_URL}/api/clock/end_session`;
    const token = localStorage.getItem("token");
    const response = await fetch(url, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    if (response.status === 200) {
      fetchLastSession();
      setIsActive(false);
      clearInterval(intervalId);
    } else if (response.status === 204) {
    } else {
      console.log("Failed to end session");
    }
  }

  const fetchNotification = async () => {
    const url = `${process.env.REACT_APP_API_URL}/api/clock/get_notification`;
    const token = localStorage.getItem("token");
    const response = await fetch(url, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    if (response.status === 401) {
      console.log("Unauthorized");
      window.location.href = "/login";
      return;
    }

    const notification = await response.json();
    return notification.message;
  };

  useEffect(() => {
    fetchLastSession();
  }, []);

  useEffect(() => {
    let id;
    if (isActive) {
      id = setInterval(async () => {
        setSeconds((seconds) => seconds + 1);
        if (seconds % 60 === 4 && seconds !== 0) {
          var notification_message = await fetchNotification();

          if ("Notification" in window) {
            if (Notification.permission !== "granted") {
              Notification.requestPermission();
            }

            if (Notification.permission === "granted") {
              new Notification("Clock Notification", {
                body: notification_message,
              });
            } else {
              alert(notification_message);
            }
          } else {
            alert(notification_message);
          }
          fetchNotifications();
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
                <i className="bi bi-pause-fill"></i>
              ) : (
                <i className="bi bi-play-fill"></i>
              )}
            </button>
          </div>
          <div className="time">{formatTime(seconds)}</div>
        </div>

        <OrSeparator text={"PROGRESS"} />

        <div className="clock-info">
          {Object.entries(notifications).map(([key, value]) => (
            <div key={key}>
              {value.map((notification) => (
                <p key={notification.id}>{notification.message}</p>
              ))}
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

export default Clock;
