import React, { useState } from "react";
import "./Forum.css";
import Sidebar from "../Sidebar/Sidebar";
import Header from "../Header/Header";
import Headings from "../Header/Headings";
import ForumPost from "./ForumPost";

// ! TO DELETE ------------ DUMMY DATA ------------ TO DELETE ! START
const posts = [
  {
    title: "How to improve my vision?",
    replies: 5,
    views: 10,
    poster: "",
    status: "",
    date: "2021-10-10",
  },
  {
    title: "Eye pain after long hours of screen time",
    replies: 3,
    views: 7,
    poster: "",
    status: "",
    date: "2021-10-11",
  },
  {
    title: "Eye drops for dry eyes",
    replies: 2,
    views: 5,
    poster: "",
    status: "",
    date: "2021-10-12",
  },
  {
    title: "How to reduce eye strain?",
    replies: 4,
    views: 8,
    poster: "",
    status: "",
    date: "2021-10-13",
  },
];
// ! TO DELETE ------------ DUMMY DATA ------------ TO DELETE ! END

function Forum() {
  return (
    <div style={{ display: "flex" }}>
      <Sidebar />

      <div className="forum-content">
        <Header pageTitle="Forum" />
        <Headings />

        <ul className="forum-elements">
          {posts.map((post) => (
            <ForumPost
              key={post.title} // TODO: LATER CHANGE TO POST ID
              title={post.title}
              replies={post.replies}
              views={post.views}
              poster={post.poster}
              status={post.status}
              date={post.date}
            />
          ))}
        </ul>
      </div>
    </div>
  );
}

export default Forum;
