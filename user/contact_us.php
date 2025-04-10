<?php
include_once "includes/header.php";
?>
<article id="contact-us">
    <div class="title">Contact Us</div>
    <div class="contact-us-details">
        <div class="contact-us-container">
            <div class="content">
                <div class="contact-detail">
                    <div class="address details">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="topic">Location</div>
                        <div class="text-one">Technology Park</div>
                        <div class="text-two">Bukit Jalil</div>
                    </div>
                    <div class="phone details">
                        <i class="fas fa-phone-alt"></i>
                        <div class="topic">Phone</div>
                        <div class="text-one">+6012 345 6789</div>
                        <div class="text-two">+6019 876 5432</div>
                    </div>
                    <div class="email details">
                        <i class="fas fa-envelope"></i>
                        <div class="topic">Email</div>
                        <div class="text-one">yeesiang68@gmail.com</div>
                        <div class="text-two">kaibinyong2002@gmail.com</div>
                    </div>
                </div>
                <div class="contact-us-form">
                    <div class="topic-text">Send us a message</div>
                    <p>If you have any problem in this website, you can send us message from here. It's our pleasure to
                        help you.</p>
                    <form action="manage_contact_us.php" method="post" onsubmit="return validate_contact_us();">
                        <div class="input-box flex-item">
                            <input type="text" name="user-name" id="user-name" placeholder="Enter your name">
                            <i class="fas fa-check-circle"></i>
                            <i class="fas fa-exclamation-circle"></i>
                            <small>Error message</small>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>
                        <div class="input-box flex-item">
                            <input type="text" name="email-address" id="email-address" placeholder="Enter your email">
                            <i class="fas fa-check-circle"></i>
                            <i class="fas fa-exclamation-circle"></i>
                            <small>Error message</small>
                            <br>
                        </div>
                        <div class="input-box flex-item">
                            <input type="tel" name="contact-number" id="contact-number"
                                placeholder="Enter your contact number">
                            <i class="fas fa-check-circle"></i>
                            <i class="fas fa-exclamation-circle"></i>
                            <small>Error message</small>
                            <br>
                        </div>
                        <div class="input-box message-box flex-item">
                            <textarea name="inquiry" id="inquiry" cols="30" rows="5"
                                placeholder="Enter your inquiry"></textarea>
                            <i class="fas fa-check-circle"></i>
                            <i class="fas fa-exclamation-circle"></i>
                            <small>Error message</small>
                            <br>
                        </div>
                        <div class="button">
                            <input type="submit" name="submit" value="Send Now">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</article>
<script defer src="../admin/scripts/form_validation.js"></script>
<?php
include_once "../admin/includes/alert_message.php";
include_once "./includes/footer.php";
?>