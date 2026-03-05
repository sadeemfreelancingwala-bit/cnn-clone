// Helper to get URL params
const getUrlParam = (name) => {
    const params = new URLSearchParams(window.location.search);
    return params.get(name);
};

// Layout Renderers
const renderNav = () => {
    const nav = document.getElementById('nav-links');
    if (!nav) return;

    // Home link
    let html = '<a href="index.html">Home</a>';

    // Category links
    window.categories.forEach(cat => {
        html += `<a href="category.html?id=${cat.id}">${cat.name}</a>`;
    });

    // Auth (Mock)
    html += `<a href="#" onclick="alert('Login disabled in demo')">Login</a>`;

    nav.innerHTML = html;
};

// Page Logic
const initHome = () => {
    // Featured
    const featured = window.news.find(n => n.is_featured);
    if (featured) {
        const featContainer = document.getElementById('featured-content');
        if (featContainer) {
            featContainer.innerHTML = `
                <div class="featured-tag">Breaking News</div>
                <h2>${featured.title}</h2>
                <p>${featured.short_description}</p>
                <a href="article.html?id=${featured.id}" class="btn-read">Read Full Story</a>
            `;
            // Set background
            const bg = document.querySelector('.featured-bg');
            if (bg) bg.style.backgroundImage = `url('${featured.image_url}')`;
        }
    }

    // Grid
    const grid = document.getElementById('news-grid');
    if (grid) {
        // Filter out featured
        const otherNews = window.news.filter(n => !n.is_featured && n.id !== featured?.id);

        grid.innerHTML = otherNews.map(n => createCard(n)).join('');
    }
};

const initCategory = () => {
    const id = parseInt(getUrlParam('id'));
    const category = window.categories.find(c => c.id === id);

    if (!category) {
        document.body.innerHTML = '<h1>Category not found</h1>';
        return;
    }

    document.title = `${category.name} - CNN Clone`;
    document.getElementById('page-title').textContent = `${category.name} News`;

    const grid = document.getElementById('news-grid');
    const catNews = window.news.filter(n => n.category_id === id);

    if (catNews.length === 0) {
        grid.innerHTML = '<p>No news in this category yet.</p>';
    } else {
        grid.innerHTML = catNews.map(n => createCard(n)).join('');
    }
};

const initArticle = () => {
    const id = parseInt(getUrlParam('id'));
    const article = window.news.find(n => n.id === id);

    if (!article) {
        document.body.innerHTML = '<h1>Article not found</h1>';
        return;
    }

    document.title = article.title;

    // Render content
    document.getElementById('article-title').textContent = article.title;
    document.getElementById('article-img').src = article.image_url;
    document.getElementById('article-date').textContent = new Date(article.created_at).toLocaleDateString();

    // Simple nl2br replacement
    document.getElementById('article-content').innerHTML = article.content.replace(/\n\n/g, '<br><br>');

    // Related
    const related = window.news
        .filter(n => n.category_id === article.category_id && n.id !== article.id)
        .slice(0, 3);

    const relatedGrid = document.getElementById('related-grid');
    if (relatedGrid && related.length > 0) {
        relatedGrid.innerHTML = related.map(n => createCard(n)).join('');
    }
};

const createCard = (n) => {
    const cat = window.categories.find(c => c.id === n.category_id);
    return `
        <div class="news-card" onclick="window.location.href='article.html?id=${n.id}'">
            <img src="${n.image_url}" alt="${n.title}" onError="this.src='https://via.placeholder.com/300'">
            <div class="card-content">
                <span class="card-category">${cat ? cat.name : 'News'}</span>
                <h3>${n.title}</h3>
                <p>${n.short_description}</p>
                <span class="read-link">Read Article &rarr;</span>
            </div>
        </div>
    `;
};

// Router
document.addEventListener('DOMContentLoaded', () => {
    renderNav();

    const path = window.location.pathname;
    // Simple path checking that works locally
    if (path.includes('index.html') || path.endsWith('/')) {
        initHome();
    } else if (path.includes('category.html')) {
        initCategory();
    } else if (path.includes('article.html')) {
        initArticle();
    } else {
        // Fallback for default opening of index if no file specified but usually file:// includes filename
        initHome();
    }
});
