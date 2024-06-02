import "./ForumPost.css";

function ForumPost({ id, title, replies, views, poster, status, date }) {
  return (
    <li key={id} className="forum-post">
      <a
        href="#"
        className="status-element"
        onClick={(e) => e.preventDefault()}
      >
        {status}
      </a>
      <a
        href={`/forum/post/${id}`}
        className="forum-text"
        onClick={async (e) => {
          e.preventDefault();
          const url = `${process.env.REACT_APP_API_URL}/api/forum/post/${id}/incrementViews`;
          const token = localStorage.getItem("token");
          const response = await fetch(url, {
            method: "GET",
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          if (response.status === 401) {
            console.log("Unauthorized");
            window.location.href = "/login";
            return;
          }
          window.location.href = `/forum/post/${id}`;
        }}
      >
        {title}
      </a>
      <span className="forum-replies">{replies}</span>
      <span className="forum-views">{views}</span>
      <a
        href={poster.username}
        className="posted-by-element"
        style={{
          backgroundImage: `url(${poster.profile_picture_url})`,
        }}
        onClick={(e) => e.preventDefault()}
      ></a>
      <span className="forum-date">{date}</span>
    </li>
  );
}

export default ForumPost;
