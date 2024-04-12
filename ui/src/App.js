import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Login from "./SiteAccess/Login";
import Register from "./SiteAccess/Register";
import Forum from "./Forum/Forum";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/forum" element={<Forum />} />
      </Routes>
    </Router>
  );
}

export default App;
