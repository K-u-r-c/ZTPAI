import React, { useState, useEffect } from "react";
import "./Forum.css";
import Sidebar from "../Sidebar/Sidebar";
import Header from "../Header/Header";
import Headings from "../Header/Headings";
import ForumPost from "./ForumPost";

function Forum() {
  const [posts, setPosts] = useState([]);

  useEffect(() => {
    const fetchPosts = async () => {
      const url = `${process.env.REACT_APP_API_URL}/api/forum/posts`;
      const token = localStorage.getItem("token");
      const response = await fetch(url, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      const posts = await response.json();
      setPosts(posts);
    };

    fetchPosts();
  }, []);

  return (
    <div style={{ display: "flex" }}>
      <Sidebar />

      <div className="forum-content">
        <Header pageTitle="Forum" />
        <Headings />

        <ul className="forum-elements">
          {/* Case there are no posts display "no posts on this forum yet" */}
          {posts.length === 0 ? (
            <p>No posts on this forum yet</p>
          ) : (
            posts.map((post) => (
              <ForumPost
                key={post.id} // TODO: LATER CHANGE TO POST ID
                title={post.title}
                replies={post.replies}
                views={post.views}
                poster={post.poster}
                status={post.status}
                date={post.date}
              />
            ))
          )}
        </ul>
      </div>
    </div>
  );
}

export default Forum;
