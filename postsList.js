import { Post } from "./src/components/PostsList.js";

const renderPostItem = (item) => `
    <a href="post.html?id=${item.id}" class="post-item">
        <span class="post-item__title">
            ${item.title}
        </span>
        <span class="post-item__body">
            ${item.body}
        </span>
    </a>
`;

const getPostItems = async ({ limit, page }) => {
    try {
        const res = await fetch(`https://jsonplaceholder.typicode.com/posts?_limit=${limit}&_page=${page}`);
        if (!res.ok) throw new Error("Error fetching posts");

        const total = +res.headers.get('x-total-count');
        const items = await res.json();
        return { items, total };
    } catch (error) {
        console.error("Error fetching posts:", error);
        return { items: [], total: 0 };
    }
};

const renderPhotoItem = (item) => `
    <a href="photos/${item.id}" class="photo-item">
        <span class="photo-item__title">
            ${item.title}
        </span>
        <img src=${item.url} class="photo-item__image">
    </a>
`;

const getPhotoItems = async ({ limit, page }) => {
    try {
        const res = await fetch(`https://jsonplaceholder.typicode.com/photos?_limit=${limit}&_page=${page}`);
        if (!res.ok) throw new Error("Error fetching photos");

        const total = +res.headers.get('x-total-count');
        const items = await res.json();
        return { items, total };
    } catch (error) {
        console.error("Error fetching photos:", error);
        return { items: [], total: 0 };
    }
};

const init = () => {
    const posts = document.getElementById("posts");
    new Post(posts, {
        renderItem: renderPostItem,
        getItems: getPostItems,
    }).init();
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
} else {
    init();
}