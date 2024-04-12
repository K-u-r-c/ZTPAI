import "./ForumPost.css";

function ForumPost({ title, replies, views, poster, status, date }) {
  return (
    <li>
      <a href="#" className="status-element">
        {status}
      </a>
      <a href="#" className="forum-text">
        {title}
      </a>
      <span className="forum-replies">{replies}</span>
      <span className="forum-views">{views}</span>
      <a href="#" className="posted-by-element">
        {poster}
      </a>
      <span className="forum-date">{date}</span>
    </li>
  );
}

export default ForumPost;