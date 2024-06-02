import "./PostReply.css";

function PostReply({ id, content, poster, date }) {
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
    <li key={id} className="post-reply">
      <div className="post-reply-header">
        <a
          href={poster.username}
          className="replied-by-element"
          style={{
            background: `url(${poster.profile_picture_url}) no-repeat 50% / cover`,
          }}
          onClick={(e) => e.preventDefault()}
        ></a>
        <div className="post-reply-header-text">
          <p className="reply-username-element">
            <b>{poster.username}</b>,
          </p>
          &nbsp;
          <p className="forum-date">{formatDate(date)}</p>
        </div>
      </div>
      <br></br>
      <div className="post-reply-content">
        <p className="reply-content">{content}</p>
      </div>
    </li>
  );
}

export default PostReply;
