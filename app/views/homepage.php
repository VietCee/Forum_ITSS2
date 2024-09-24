<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/public/css/homePage.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-left">
            <img src="logo.png" alt="Facebook Logo" class="logo">
        </div>
        <div class="navbar-center">
            <input type="text" class="search-bar" placeholder="Search Facebook">
        </div>
        <div class="navbar-right">
            <div class="nav-item">Home</div>
            <div class="nav-item">Friends</div>
            <div class="nav-item">Messages</div>
            <div class="nav-item">Notifications</div>
            <div class="nav-item">Profile</div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul>
                <li>News Feed</li>
                <li>Messenger</li>
                <li>Watch</li>
                <li>Marketplace</li>
                <li>Groups</li>
            </ul>
        </aside>

        <!-- Feed Section -->
        <section class="feed">
            <div class="status-box">
                <textarea placeholder="What's on your mind?"></textarea>
                <button>Post</button>
            </div>

            <!-- Sample Post -->
            <div class="post">
                <div class="post-header">
                    <img src="profile-pic.jpg" alt="Profile Picture" class="profile-pic">
                    <div class="post-info">
                        <h3>User Name</h3>
                        <p>1 hour ago</p>
                    </div>
                </div>
                <div class="post-content">
                    <p>This is a sample post on Facebook clone.</p>
                </div>
                <div class="post-actions">
                    <button>Like</button>
                    <button>Comment</button>
                    <button>Share</button>
                </div>
            </div>
        </section>

        <!-- Right Sidebar -->
        <aside class="right-sidebar">
            <h4>Sponsored</h4>
            <div class="ad">
                <p>Ad content here...</p>
            </div>
            <h4>Contacts</h4>
            <div class="contact-list">
                <p>Friend 1</p>
                <p>Friend 2</p>
                <p>Friend 3</p>
            </div>
        </aside>
    </div>
</body>
</html>
