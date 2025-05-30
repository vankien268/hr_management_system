<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Permanent+Marker");
        @import url("https://fonts.googleapis.com/css?family=Roboto+Mono");

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f3e2cb;
            display: flex;
            flex-direction: column;
            align-items: center;
            align-content: center;
        }

        .wrapper {
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column-reverse;
            align-items: center;
            align-content: center;
            position: absolute;
            bottom: 0;
            overflow: hidden;
        }

        .wrapper:hover .sun {
            transform: translateY(-200px);
        }

        .pedastal {
            width: 1000px;
            height: 90px;
            background: white;
            position: relative;
        }

        .pedastal-block1,
        .pedastal-block1::before {
            width: 125px;
            height: 30px;
            background: #a24d4c;
            box-sizing: border-box;
        }

        .pedastal-block1::before {
            content: "";
            position: absolute;
            right: 0;
        }

        .pedastal-block2,
        .pedastal-block2::before {
            width: 63px;
            height: 30px;
            background: #a24d4c;
            box-sizing: border-box;
        }

        .pedastal-block2::before {
            content: "";
            position: absolute;
            right: 0;
        }

        .hall {
            width: 520px;
            height: 60px;
            background: #44291e;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            position: relative;
            z-index: 3;
        }

        .hall-pillar {
            height: 100%;
            width: 16px;
            background: linear-gradient(90deg, #da5447, #9c4e46);
        }

        .hall-support {
            width: 40px;
            height: 12px;
            position: relative;
        }

        .hall-support::before {
            content: "";
            width: 16px;
            height: 12px;
            background: linear-gradient(135deg, #678b80 50%, transparent 51%) no-repeat;
            background-position: -2px 0;
            position: absolute;
            top: 0;
            left: 0;
        }

        .hall-support::after {
            content: "";
            width: 16px;
            height: 12px;
            background: linear-gradient(-135deg, #678b80 50%, transparent 51%) no-repeat;
            background-position: 2px 0;
            position: absolute;
            top: 0;
            right: 0;
        }

        .lower-support {
            width: 520px;
            height: 30px;
            background: #7ba598;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            position: relative;
            border-left: 4px solid #7ba598;
            border-right: 4px solid #7ba598;
            z-index: 3;
        }

        .lower-support-pillar {
            height: 100%;
            width: 16px;
            background: linear-gradient(90deg, #87c9b6, #678b80);
        }

        .ornaments {
            width: 40px;
            height: 30px;
            display: flex;
        }

        .ornaments div {
            width: 20px;
            height: 30px;
            position: relative;
        }

        .ornaments div:first-child::before,
        .ornaments div:first-child::after {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 4px;
            background: #eedb44;
            position: absolute;
        }

        .ornaments div:first-child::before {
            top: 6px;
            left: 11px;
        }

        .ornaments div:first-child::after {
            bottom: 6px;
            left: 11px;
        }

        .ornaments div:last-child::before,
        .ornaments div:last-child::after {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 4px;
            background: #eedb44;
            position: absolute;
        }

        .ornaments div:last-child::before {
            top: 6px;
            right: 11px;
        }

        .ornaments div:last-child::after {
            bottom: 6px;
            right: 11px;
        }

        .lower-roof {
            width: 376px;
            height: 40px;
            background: #fdbb3b;
            position: relative;
            z-index: 3;
        }

        .lower-roof::before {
            content: "";
            border-left: 112px solid transparent;
            border-bottom: 40px solid #fdbb3b;
            position: absolute;
            bottom: 0;
            left: -112px;
        }

        .lower-roof::after {
            content: "";
            border-right: 112px solid transparent;
            border-bottom: 40px solid #fdbb3b;
            position: absolute;
            bottom: 0;
            right: -112px;
        }

        .lower-roof div:first-child {
            display: inline-block;
            border-left: 36px solid transparent;
            border-top: 15px solid #d0982e;
            position: absolute;
            left: -112px;
            bottom: -15px;
        }

        .lower-roof div:last-child {
            display: inline-block;
            border-right: 36px solid transparent;
            border-top: 15px solid #d0982e;
            position: absolute;
            right: -112px;
            bottom: -15px;
        }

        .upper-support {
            width: 376px;
            height: 20px;
            background: #7ba598;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            position: relative;
            z-index: 3;
        }

        .upper-support .container {
            width: 296px;
            height: 20px;
            display: flex;
            align-self: center;
            flex-direction: row;
            justify-content: space-between;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .upper-support .ornaments div:first-child::after,
        .upper-support .ornaments div:last-child::after {
            display: none;
        }

        .upper-support .ornaments div:first-child::before,
        .upper-support .ornaments div:last-child::before {
            width: 6px;
            height: 6px;
        }

        .upper-support .ornaments div:first-child::before {
            top: 7px;
            left: 8px;
        }

        .upper-support .ornaments div:last-child::before {
            top: 7px;
            right: 8px;
        }

        .upper-roof {
            width: 520px;
            height: 90px;
            position: relative;
            z-index: 3;
        }

        .upper-roof div:first-child {
            display: inline-block;
            border-left: 72px solid transparent;
            border-top: 20px solid #d0982e;
            position: absolute;
            left: 0px;
            bottom: -20px;
        }

        .upper-roof div:last-child {
            display: inline-block;
            border-right: 72px solid transparent;
            border-top: 20px solid #d0982e;
            position: absolute;
            right: 0px;
            bottom: -20px;
        }

        .upper-roof-curved {
            width: 100px;
            height: 78px;
            background: #f3e2cb;
            position: absolute;
            z-index: 1000;
        }

        .upper-roof-curved:nth-child(2) {
            left: -102px;
            top: -2px;
            transform: rotate(3deg);
            border-radius: 0 0 100px 0;
        }

        .upper-roof-curved:nth-child(3) {
            right: -102px;
            top: -2px;
            transform: rotate(-3deg);
            border-radius: 0 0 0 100px;
        }

        .roof-top div:last-child::before,
        .roof-top div:last-child::after,
        .roof-top div:first-child::before,
        .roof-top div:first-child::after,
        .roof-top div {
            width: 8px;
            height: 8px;
            background: #fdbb3b;
            position: absolute;
        }

        .roof-top {
            width: 264px;
            position: relative;
            z-index: 3;
        }

        .roof-top div {
            top: -8px;
        }

        .roof-top div:first-child {
            left: 0px;
        }

        .roof-top div:first-child::before,
        .roof-top div:first-child::after {
            content: "";
            left: 8px;
        }

        .roof-top div:first-child::after {
            bottom: 8px;
        }

        .roof-top div:last-child {
            right: 0px;
        }

        .roof-top div:last-child::before,
        .roof-top div:last-child::after {
            content: "";
            right: 8px;
        }

        .roof-top div:last-child::after {
            bottom: 8px;
        }

        .sign {
            width: 12px;
            height: 16px;
            background: #490ced;
            border: 4px solid #9c4e46;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .trapezium {
            border-bottom: 90px solid #f8dab2;
            border-right: 50px solid transparent;
            border-left: 50px solid transparent;
            width: 288px;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .trapezium div {
            position: absolute;
            bottom: -90px;
            width: 20px;
        }

        .trapezium div::before {
            content: "";
            position: absolute;
            width: 20px;
        }

        .trapezium div:first-child {
            left: 24px;
            border-bottom: 90px solid white;
            border-left: 40px solid transparent;
        }

        .trapezium div:first-child::before {
            border-top: 90px solid white;
            border-right: 40px solid transparent;
        }

        .trapezium div:last-child {
            right: 24px;
            border-bottom: 90px solid white;
            border-right: 40px solid transparent;
        }

        .trapezium div:last-child::before {
            border-top: 90px solid white;
            border-left: 40px solid transparent;
            right: 0;
        }

        .wall {
            width: 100%;
            height: 90px;
            background: #a24d4c;
            position: fixed;
            bottom: 0;
            z-index: -1;
            display: flex;
            justify-content: center;
        }

        .wall::before {
            content: "";
            width: 100%;
            max-width: 1240px;
            height: 140px;
            background: #a24d4c;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .wall-roofing-bottom {
            width: 100%;
            height: 24px;
            background: #fdbb3b;
        }

        .wall-roofing-top {
            width: 1240px;
            height: 24px;
            background: #fdbb3b;
            position: absolute;
            top: -50px;
        }

        .wall-roofing-top::before {
            content: "";
            border-bottom: 24px solid #fdbb3b;
            border-left: 10px solid transparent;
            position: absolute;
            left: -10px;
        }

        .wall-roofing-top::after {
            content: "";
            border-bottom: 24px solid #fdbb3b;
            border-right: 10px solid transparent;
            position: absolute;
            right: -10px;
        }

        .sun {
            width: 400px;
            height: 400px;
            background: #ca502e;
            border-radius: 200px;
            z-index: 1;
            position: absolute;
            transform: translateY(-100px);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 1s;
        }

        .cloud {
            background: white;
            position: relative;
            z-index: 2;
        }

        .cloud::before,
        .cloud::after {
            background: white;
            display: block;
        }

        .cloud-01 {
            width: 88px;
            height: 32px;
            border-radius: 16px;
            transform: translate(-200px, -50px);
            -webkit-animation: cloud-1 50s ease-in-out infinite alternate;
            animation: cloud-1 50s ease-in-out infinite alternate;
        }

        .cloud-01::before {
            content: "";
            width: 50px;
            height: 50px;
            border-radius: 25px;
            display: block;
            transform: translate(22px, -25px);
        }

        .cloud-02 {
            width: 100px;
            height: 40px;
            border-radius: 20px;
            transform: translate(60px, -120px);
            -webkit-animation: cloud-2 40s ease-in-out infinite alternate;
            animation: cloud-2 40s ease-in-out infinite alternate;
        }

        .cloud-02::before {
            content: "";
            width: 46px;
            height: 46px;
            border-radius: 23px;
            transform: translate(38px, -23px);
        }

        .cloud-02::after {
            content: "";
            width: 30px;
            height: 30px;
            border-radius: 15px;
            transform: translate(16px, -60px);
        }

        .cloud-03 {
            width: 70px;
            height: 24px;
            border-radius: 12px;
            transform: translate(210px, 0px);
            -webkit-animation: cloud-3 30s ease-in-out infinite alternate;
            animation: cloud-3 30s ease-in-out infinite alternate;
        }

        .cloud-03::before {
            content: "";
            width: 14px;
            height: 14px;
            border-radius: 7px;
            transform: translate(46px, -7px);
        }

        .cloud-03::after {
            content: "";
            width: 16px;
            height: 16px;
            border-radius: 8px;
            top: 0;
            transform: translate(12px, -50px);
        }

        .cloud-03 div {
            width: 30px;
            height: 30px;
            background: white;
            border-radius: 15px;
            display: block;
            transform: translate(24px, -30px);
        }

        .copy {
            font-family: "Permanent Marker", cursive;
            font-size: 8em;
            color: #f3e2cb;
            padding-bottom: 60px;
        }

        .headline {
            text-align: center;
            position: relative;
            padding-top: 40px;
            z-index: 3;
        }

        .headline h1 {
            font-family: "Permanent Marker", cursive;
            color: #2b2b2b;
            font-size: 8em;
            margin: 0;
        }

        .headline h2 {
            font-family: "Roboto Mono", monospace;
            font-size: 1.25em;
            color: #2b2b2b;
        }

        @-webkit-keyframes cloud-1 {
            0% {
                transform: translate(-200px, -50px);
            }

            100% {
                transform: translate(-280px, -50px);
            }
        }

        @keyframes cloud-1 {
            0% {
                transform: translate(-200px, -50px);
            }

            100% {
                transform: translate(-280px, -50px);
            }
        }

        @-webkit-keyframes cloud-2 {
            0% {
                transform: translate(60px, -120px);
            }

            100% {
                transform: translate(300px, -120px);
            }
        }

        @keyframes cloud-2 {
            0% {
                transform: translate(60px, -120px);
            }

            100% {
                transform: translate(300px, -120px);
            }
        }

        @-webkit-keyframes cloud-3 {
            0% {
                transform: translate(210px, 0px);
            }

            100% {
                transform: translate(100px, 0px);
            }
        }

        @keyframes cloud-3 {
            0% {
                transform: translate(210px, 0px);
            }

            100% {
                transform: translate(100px, 0px);
            }
        }

        @media only screen and (max-width: 1440px) {
            .headline h1 {
                font-size: 4em;
            }

            .headline h2 {
                font-size: 1em;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <section class="pedastal">
            <div class="pedastal-block1"></div>
            <div class="pedastal-block2"></div>
            <div class="trapezium">
                <div></div>
                <div></div>
            </div>
        </section>
        <section class="hall">
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
            <div class="hall-support"></div>
            <div class="hall-pillar"></div>
        </section>
        <section class="lower-support">
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="lower-support-pillar"></div>
        </section>
        <section class="lower-roof">
            <div></div>
            <div></div>
        </section>
        <section class="upper-support">
            <div class="container">
                <div class="lower-support-pillar"></div>
                <div class="lower-support-pillar"></div>
                <div class="lower-support-pillar"></div>
                <div class="lower-support-pillar"></div>
                <div class="lower-support-pillar"></div>
                <div class="lower-support-pillar"></div>
            </div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <div class="ornaments">
                <div></div>
                <div></div>
            </div>
            <section class="sign"></section>
        </section>
        <section class="upper-roof">
            <div></div>
            <svg width="520px" height="90px">
                <path
                    d="M495.689265,72.9065145 L520,90 L0,90 L24.3069308,72.9091893 L45.9698498,74.0444947 C88.9890231,76.2990341 125.690619,43.2527689 127.945158,0.233595624 L127.687016,0.220066965 L128,0 L392,0 L392.30918,0.217392187 L392,0.233595624 C394.254539,43.2527689 430.956135,76.2990341 473.975308,74.0444947 L495.689265,72.9065145 Z"
                    id="Combined-Shape" fill="#FDBB3B"></path>
            </svg>
            <div></div>
        </section>
        <section class="roof-top">
            <div></div>
            <div></div>
        </section>
        <div class="cloud cloud-01"></div>
        <div class="cloud cloud-02"></div>
        <div class="cloud cloud-03">
            <div></div>
        </div>
        <div class="sun">
            <div class="copy">403</div>
        </div>
    </div>
    <div class="wall">
        <div class="wall-roofing-bottom"></div>
        <div class="wall-roofing-top"></div>
    </div>
    <div class="headline">
        <h1>Something Went Wrong</h1>
        <h2>✋ Bạn không có quyền truy cập 🚧 vui lòng <a href="{{ url()->previous() }}">quay lại</a>✋</h2>
    </div>
</body>

</html>
