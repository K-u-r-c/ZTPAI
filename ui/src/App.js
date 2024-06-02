import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Login from "./SiteAccess/Login";
import Register from "./SiteAccess/Register";
import Forum from "./Forum/Forum";
import UserPage from "./SiteAccess/UserPage";
import Post from "./Forum/Post";
import Clock from "./Clock/Clock";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/forum" element={<Forum />} />
        <Route path="/user" element={<UserPage />} />
        <Route path="/logout" element={<Login />} />
        <Route path="/forum/post/:id" element={<Post />} />
        <Route path="/clock" element={<Clock />} />
      </Routes>
    </Router>
  );
}

export default App;
