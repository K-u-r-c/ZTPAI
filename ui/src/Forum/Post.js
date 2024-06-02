import { useParams } from "react-router-dom";
import { useEffect, useState } from "react";
import Sidebar from "../Sidebar/Sidebar";
import Header from "../Header/Header";
import "./Post.css";
import PostReply from "./PostReply";
import axios from "axios";

function Post() {
  const { id } = useParams();
  const [post, setPost] = useState({ replies: [] });

  const fetchPost = async (postId) => {
    const url = `${process.env.REACT_APP_API_URL}/api/forum/post/${postId}`;
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
    const post = await response.json();
    return post;
  };

  useEffect(() => {
    fetchPost(id).then((post) => {
      setPost(post);
    });
  }, []);

  const [formData, setFormData] = useState({
    content: "",
  });

  const [showForm, setShowForm] = useState(false);

  const handleNewReplySubmit = async (e) => {
    e.preventDefault();

    const url = `${process.env.REACT_APP_API_URL}/api/forum/create_reply`;
    const token = localStorage.getItem("token");
    axios({
      method: "POST",
      url: url,
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      data: JSON.stringify({
        ...formData,
        postId: id,
      }),
    })
      .then((res) => res.data)
      .then((result) => {
        if (result.success) {
          fetchPost(id).then((post) => {
            setPost(post);
            setShowForm(false);
          });
        }
      });
  };

  const handleNewReplyClick = (e) => {
    e.preventDefault();
    setShowForm(true);
  };

  const handleFormClose = (e) => {
    e.preventDefault();
    setShowForm(false);
  };

  return (
    <div style={{ display: "flex" }}>
      <Sidebar />

      <div className="forum-content">
        <Header pageTitle={`Forum - ${post.title}`} />

        <div className="post-section">
          <h1 className="post-title">{post.title}</h1>
          <p>{post.content}</p>
        </div>
        <div className="replies-section">
          <h1 className="replies-header">Replies: </h1>
          {post.replies.length === 0 ? (
            <h3
              style={{
                color: "black",
                textAlign: "center",
                marginTop: "50px",
              }}
            >
              No replies to this post yet
            </h3>
          ) : (
            post.replies.map((reply) => (
              <PostReply
                id={reply.id}
                title={reply.title}
                content={reply.content}
                poster={reply.userId}
                date={reply.repliedAt}
              />
            ))
          )}
        </div>
        <a
          href="forum/new-reply"
          className="new-reply-button"
          onClick={handleNewReplyClick}
        >
          <i className="bi bi-plus-square-fill"></i>
        </a>

        {showForm && (
          <div className="add-new-reply-window">
            {
              <form
                className="new-reply-form"
                method="POST"
                onSubmit={handleNewReplySubmit}
              >
                <h2>New Reply</h2>
                <a
                  href="forum"
                  className="new-reply-close-button"
                  onClick={handleFormClose}
                >
                  <i className="bi bi-x-circle-fill"></i>
                </a>

                <div className="new-reply-form-field">
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

                <button type="submit" className="new-reply-submit-button">
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

export default Post;
