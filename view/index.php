<?php
session_start();
ob_start();
$navbar= true;
$pageTitle= "Main";
$page= "index";
include "../helper/init.php";
if(isset($_SESSION['uName'])){
    header("Location:home.php");
}
// include "../admin/controller/userController.php";
?>



    <div class="inner-container">
        <div class="heading">
            <h1> Unlimited movies, TV <br/> shows, and more. </h1>
            <h3>Watch anywhere. Cancel anytime.</h3>
        </div>
        <div class="caption">
            <h5>Ready to watch? Enter your email to create or restart your membership.</h5>
        </div>
        <div class="form-outer-container">
            <form action="auth.php?page=signup" method="POST" class="form-inner-container">
                 <div class="input-container">
                    <input size="65" type="email" name="email" placeholder="Email"/>
                    <button type="submit" name="submit">Get Started <i class="fas fa-chevron-right"></i> </button>
                </div>
            </form>
        </div>
    </div>


    </div>
    <section class="second-section" >
        <div class="caption1">
           <h1>Enjoy on your TV.</h1>
           <h3>Watch on Smart TVs, Playstation, Xbox,<br/> Chromecast, Apple TV, Blu-ray players, and <br/> more.</h3>
        </div>
        <div class="img-section">
            <img src="../helper/imgs/tv.png"/>
        </div>
    </section>

    <section class="second-section" >
        <div class="img-section">
            <img src="../helper/imgs/mobile-0819.jpg"/>
        </div>
        <div class="caption2">
           <h1>Download your shows <br/> to watch offline.</h1>
           <h3>Save your favorites easily and always have <br/> something to watch.</h3>
        </div>
    </section>

    <section class="second-section" >
        <div class="caption1">
           <h1>Watch everywhere.</h1>
           <h3>Stream unlimited movies and TV shows on <br/> your phone, tablet, laptop, and TV without <br/> paying more.</h3>
        </div>
        <div class="img-section">
            <img src="../helper/imgs/device-pile.png"/>
        </div>
    </section>

    <section class="freq-section">
        <h1 class="freq">Frequently Asked Questions</h1>
        <div class="ques">
            <p>What is Netflix?</p>
            <i class="fas fa-plus open display"></i>
            <i class="fas fa-times close hide"></i>
        </div>
        <div class="answ hide">
            <p> is a streaming service that offers a wide variety of <br/> award-winning TV shows, movies, anime, documentaries, and <br/> more on thousands of internet-connected devices.
            </p>
            <p>
            You can watch as much as you want, whenever you want <br/> without a single commercial – all for one low monthly price. <br/> There's always something new to discover and new TV shows <br/> and movies are added every week!
            </p>
        </div>
        <div class="ques">
            <p>How much does Netflix cost?</p>
            <i  class="fas fa-plus open display"></i>
            <i  class="fas fa-times close hide"></i>
        </div>
        <div class="answ hide">
            <p> Watch Netflix on your smartphone, tablet, Smart TV, laptop, or <br/> streaming device, all for one fixed monthly fee. Plans range <br/> from SAR32 to SAR61 a month. No extra costs, no contracts.
            </p>
        </div>
        <div class="ques">
            <p>Where can I watch?</p>
            <i  class="fas fa-plus open display"></i>
            <i  class="fas fa-times close hide"></i>
        </div>
        <div class="answ hide">
            <p class="where-mobile" > Watch anywhere, anytime, on an unlimited number of devices. <br/> Sign in with your Netflix account to watch instantly on the web <br/> at netflix.com from your personal computer or on any internet <br/> -connected device that offers the Netflix app, including smart <br/> TVs, smartphones, tablets, streaming media players and game <br/> consoles.
            </p>
            <p class="where-mobile">
            You can also download your favorite shows with the iOS, <br/> Android, or Windows 10 app. Use downloads to watch while <br/> you're on the go and without an internet connection. Take <br/> Netflix with you anywhere.
            </p>
        </div>

        <div class="ques">
            <p>How do I cancel?</p>
            <i  class="fas fa-plus open display"></i>
            <i  class="fas fa-times close hide"></i>
        </div>
        <div class="answ hide">
            <p> Netflix is flexible. There are no pesky contracts and no <br/> commitments. You can easily cancel your account online in two <br/> clicks. There are no cancellation fees – start or stop your <br/> account anytime.
            </p>
        </div>
        <div class="ques">
            <p>What can I watch on Netflix?</p>
            <i  class="fas fa-plus open display"></i>
            <i  class="fas fa-times close hide"></i>
        </div>
        <div class="answ hide">
            <p> Netflix has an extensive library of feature films, documentaries, <br/> TV shows, anime, award-winning Netflix originals, and more. <br/> Watch as much as you want, anytime you want.
            </p>
        </div>
        
        <div class="form-outer-container" >
            <div class="caption" style="margin-bottom: -3%;">
                <h5>Ready to watch? Enter your email to create or restart your membership.</h5>
            </div>
            <form action="auth.php?page=signup" method="POST" class="form-inner-container">
                 <div class="input-container">
                    <input size="65" type="email" name="email" placeholder="Email"/>
                    <button type="submit" name="submit">Get Started <i class="fa fa-chevron-right"></i> </button>
                </div>
            </form>
        </div>

    </section>

    <section class="footer-section" >
        <p class="call">Questions? Call <a href="tel:800-850-1262">800-850-1262</a></p>
        <div class="grid-footer">
            <div class="list">
                <p>FAQ</p>
                <p>Investor Relations</p>
                <p>Ways to Watch</p>
                <p>Corporate Information</p>
                <p>Netflix Originals</p>
            </div>
            <div class="list">
                <p>Help Center</p>
                <p>Jobs</p>
                <p>Terms of Use</p>
                <p>Contact Us</p>
            </div>
            <div class="list">
                <p>Account</p>
                <p>Redeem Gift Cards</p>
                <p>Privacy</p>
                <p>Speed Test</p>
            </div>
            <div class="list">
                <p>Media Center</p>
                <p>Buy Gift Cards</p>
                <p>Cookie Preferences</p>
                <p>Legal Notices</p>
            </div>
        </div>
    </section>


<?php

include "../reusable/footer.php";
ob_end_flush();

?>