<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/components/Feedback-section.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <title>Feedback</title>
    <script defer src="../js/Feedback-section.js"></script>
</head>

<body>
    <div class="feedback-container">
        <div class="feedback-user-info">
            <div class="user-img"> <img src="../assets/img/user-info2.png" alt=""></div>
            <div class="user-name-phone_number">
                <p><span style="font-size: 4ch;">User name</span> : ADEL GARAMIDA</p>
                <p><span style="font-size: 3ch;">Phone Number : </span> 0712345678</p>
            </div>
        </div>
        <div class="feedback-form">
            <form action="">
                <div style="text-align: right; font-size: 3ch; font-weight: bold;">
                    <label for="feedback-text;" > :  (أبدنا رأيك في محتوى المنصة) Feedback</label>
                </div>

                <br>
                <textarea name="feedback" id="feedback-text" dir="rtl"></textarea>

                <br>
                <div class="stars-rating">
                    <p dir="rtl">تقيمك للمنصة :</p>
                    <div id="stars-rate">
                        <label for="star1" id="star1-label"><i class="fa-solid fa-star star1"></i></label>
                        <input id="star1" type="radio">
                        <label for="star2" id="star2-label"><i class="fa-solid fa-star star2"></i></label>
                        <input id="star2" type="radio">
                        <label for="star3" id="star3-label"><i class="fa-solid fa-star star3"></i></label>
                        <input id="star3" type="radio">
                        <label for="star4" id="star4-label"><i class="fa-solid fa-star star4" ></i></label>
                        <input id="star4" type="radio">
                        <label for="star5" id="star5-label"><i class="fa-solid fa-star star5"></i></label>
                        <input id="star5" type="radio">
                        
                    </div>
                    <div>
                        <input type="submit" value="send" id="submit-feedback">
                    </div>
                </div>
            </form>
        </div>

    </div>
</body>

</html>