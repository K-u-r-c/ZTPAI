import React, { useState, useEffect } from "react";
import "./Forum.css";
import Sidebar from "../Sidebar/Sidebar";
import Header from "../Header/Header";
import Headings from "../Header/Headings";
import ForumPost from "./ForumPost";
import axios from "axios";

function Forum() {
  const [posts, setPosts] = useState([]);

  const fetchPosts = async () => {
    const url = `${process.env.REACT_APP_API_URL}/api/forum/posts`;
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

    const posts = await response.json();
    setPosts(posts);
  };

  useEffect(() => {
    fetchPosts();
  }, []);

  const [showForm, setShowForm] = useState(false);

  const handleNewPostClick = (e) => {
    e.preventDefault();
    setShowForm(true);
  };

  const handleFormClose = (e) => {
    e.preventDefault();
    setShowForm(false);
  };

  const [formData, setFormData] = useState({
    title: "",
    content: "",
  });

  const handleNewPostSubmit = async (e) => {
    e.preventDefault();

    const url = `${process.env.REACT_APP_API_URL}/api/forum/create_post`;
    const token = localStorage.getItem("token");
    axios({
      method: "POST",
      url: url,
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      data: JSON.stringify(formData),
    })
      .then((res) => res.data)
      .then((result) => {
        if (result.success) {
          fetchPosts();
        }
      });
  };

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = {
      year: "numeric",
      month: "long",
      day: "numeric",
      hour: "numeric",
      minute: "numeric",
    };
    return date.toLocaleDateString(undefined, options);
  };

  return (
    <div style={{ display: "flex" }}>
      <Sidebar />

      <div className="forum-content">
        <Header pageTitle="Forum" />
        <Headings />

        <ul className="forum-elements">
          {posts.length === 0 ? (
            <h3
              style={{
                color: "black",
                textAlign: "center",
                marginTop: "50px",
              }}
            >
              No posts on this forum yet
            </h3>
          ) : (
            posts.map((post) => (
              <ForumPost
                key={post.id}
                title={post.title}
                replies={post.replies.length}
                views={post.views}
                poster={post.poster}
                status={post.status}
                date={formatDate(post.postedAt)}
              />
            ))
          )}
        </ul>

        <a
          href="forum/new-post"
          className="new-post-button"
          onClick={handleNewPostClick}
        >
          <i className="bi bi-plus-square-fill"></i>
        </a>

        {showForm && (
          <div className="add-new-post-window">
            {
              <form
                className="new-post-form"
                method="POST"
                onSubmit={handleNewPostSubmit}
              >
                <h2>New Post</h2>
                <a
                  href="forum"
                  className="new-post-close-button"
                  onClick={handleFormClose}
                >
                  <i className="bi bi-x-circle-fill"></i>
                </a>

                <div className="new-post-form-field">
                  <label>Title:</label>
                  <input
                    onChange={(e) => {
                      setFormData({ ...formData, title: e.target.value });
                    }}
                    type="text"
                    name="title"
                    placeholder="Title"
                    required
                  />
                </div>

                <div className="new-post-form-field">
                  <label>Content:</label>
                  <textarea
                    onChange={(e) => {
                      setFormData({ ...formData, content: e.target.value });
                    }}
                    name="content"
                    placeholder="Content"
                    required
                  ></textarea>
                </div>

                <button type="submit" className="new-post-submit-button">
                  Submit
                </button>
              </form>
            }
          </div>
        )}
      </div>
    </div>
  );
}

export default Forum;
