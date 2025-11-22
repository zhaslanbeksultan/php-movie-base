<?php include '../includes/header.php'; ?>

<section class="news-detail-page">
    <div id="news-content">
        <!-- Will be populated by JavaScript -->
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Loading news...</p>
        </div>
    </div>
    
    <!-- Comments Section -->
    <div id="comments-section" class="comments-section" style="display: none;">
        <h3>💬 Comments</h3>
        <div id="comments-list" class="comments-list">
            <!-- Comments will be loaded here -->
        </div>
        
        <!-- Comment Form -->
        <div class="comment-form-section">
            <h4>Leave a Comment</h4>
            <form id="comment-form" class="comment-form">
                <input type="hidden" id="news-id-input" name="news_id">
                <input type="text" id="comment-author" name="author" placeholder="Your name" required>
                <textarea id="comment-text" name="text" placeholder="Write your comment..." required></textarea>
                <button type="submit">Post Comment</button>
            </form>
        </div>
    </div>
</section>

<!-- Load JavaScript modules -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js"></script>

<script src="../assets/js/data.js"></script>
<script src="../assets/js/ui.js"></script>
<script src="../assets/js/events.js"></script>
<script src="../assets/js/news-detail.js"></script>

<?php include '../includes/footer.php'; ?>