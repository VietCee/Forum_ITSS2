<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/public/css/homePage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-left">
            <img src="/public/img/446foxface2_100697.ico" alt="Facebook Logo" class="logo">
        </div>
        <div class="navbar-center">
            <!-- <input type="text" class="search-bar" placeholder="Search Facebook"> -->
            <!-- <div class="nav-title">SmallFood</div> -->
             <h1>SmallFood</h1>
        </div>
        <div class="navbar-right">
            <!-- <div class="nav-item">Home</div>
            <div class="nav-item">Saved</div>
            <div class="nav-item">Users</div>
            <div class="nav-item">Notifications</div>
            <div class="nav-item">Profile</div> -->
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul>
                <li><i class="fas fa-home" style="width: 20px;"></i> Home</li>
                <li><i class="fas fa-bookmark" style="width: 20px; padding-left:2px"></i> Saved</li>
                <li><i class="fas fa-user" style="width: 20px;"></i> Users</li>
                <li><i class="fas fa-magnifying-glass" style="width: 20px;"></i> Search</li>
            </ul>
        </aside>

        <!-- Feed Section -->
        <section class="feed">
            <div class="status-box">
                <textarea placeholder="What's on your mind?"></textarea>
                <input type="file" name="image">
                <input type="text" name="tag" placeholder="Add tags">
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
                    <button style="padding-left: 10px;"><i class="fas fa-thumbs-up"></i> Like</button>
                    <button><i class="fas fa-comment"></i> Comment</button>
                    <button style="padding-right: 10px;"><i class="fas fa-share"></i> Share</button>
                </div>
            </div>
        </section>

        <!-- Right Sidebar -->
        <aside class="right-sidebar">
            <h4>Sponsored</h4>
            <div class="ad">
                <p>Ad content here...</p>
            </div>
            <h4>Trending</h4>
            <div class="contact-list">
                <p>#cake</p>
                <p>#spicy</p>
                <p>#stupid</p>
            </div>
        </aside>
    </div>
</body>
</html>
