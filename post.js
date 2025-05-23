const getPostIdFromUrl = () => {
    const params = new URLSearchParams(window.location.search);
    return params.get('id');
};

const loadPostDetails = async () => {
    const postId = getPostIdFromUrl();
    if (!postId) {
        document.body.innerHTML = '<h1>Post not found</h1>';
        return;
    }

    try {
        const res = await fetch(`https://jsonplaceholder.typicode.com/posts/${postId}`);
        if (!res.ok) throw new Error("Error downloading post");

        const post = await res.json();

        document.querySelector("[data-post-id]").textContent = "id: " + post.id;
        document.querySelector("[data-post-userId]").textContent = "userId: " + post.userId;
        document.querySelector("[data-post-title]").textContent = "title: " + post.title;
        document.querySelector("[data-post-body]").textContent = "body: " + post.body;

        loadComments(postId);
    } catch (error) {
        console.error("Error downloading post:", error);
        document.body.innerHTML = `<h1>Error downloading post: ${error.message}</h1>`;
    }
};

const loadComments = async (postId) => {
    try {
        const res = await fetch(`https://jsonplaceholder.typicode.com/posts/${postId}/comments`);
        if (!res.ok) throw new Error("Error loading comments");

        const comments = await res.json();
        const commentsContainer = document.querySelector("[data-comments]");

        if (comments.length === 0) {
            commentsContainer.innerHTML = "<p>No comments yet.</p>";
            return;
        }

        commentsContainer.innerHTML = comments.map(comment => `
            <div class="comment-item">
                <div>postId: ${comment.postId}</div>
                <div>id: ${comment.id}</div>
                <div class="comment-item__name">name: ${comment.name}</div>
                <div>body: ${comment.body}</div>
                <div>email: ${comment.email}</div>
            </div>
        `).join("");
    } catch (error) {
        console.error("Error loading comments:", error);
        document.querySelector("[data-comments]").innerHTML = `<h1>Failed to load comments: ${error.message}</h1>`;
    }
};

document.addEventListener("DOMContentLoaded", loadPostDetails);