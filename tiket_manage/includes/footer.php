        </div> <!-- Close container div if open -->
    </div>
    
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Technician Ticket System. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
    <script>
        // Close alert messages
        $(document).ready(function() {
            $(".alert .close").click(function() {
                $(this).parent().fadeOut();
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $(".alert").fadeOut();
            }, 5000);
        });
    </script>
</body>
</html>