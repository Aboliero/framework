

<!--<script>-->
<!--    for (i = 0; i < 3; i++) {-->
<!--//        alert('HELLO WORLD');-->
<!--    }-->
<!--</script>-->

<!--<script>-->
<!--    function getSummator(a) {-->
<!--        return function (b) {-->
<!--            return a + b;-->
<!--        }-->
<!--    }-->
<!---->
<!--    summator = getSummator(1);-->
<!---->
<!--    function Human() {-->
<!--        this.test = 666;-->
<!--        this.speed = 1;-->
<!--    }-->
<!---->
<!--    function African() {-->
<!--        this.speed = 5;-->
<!--    }-->
<!---->
<!--    Human.prototype.walk = function (time) {-->
<!--        return time * this.speed;-->
<!--    };-->
<!---->
<!--    African.prototype = new Human();-->
<!---->
<!--    bolt = new African();-->
<!---->
<!--    human1 = new Human();-->
<!--    human2 = new Human();-->
<!--    human3 = new Human();-->
<!---->
<!--    Object.prototype.lucky = 123;-->
<!--    Human.prototype.test = 321;-->
<!---->
<!--    human2.speed = 3;-->
<!---->
<!--    String.prototype.toLowerCase = function () {-->
<!--        return 'FUCK YOU!';-->
<!--    };-->
<!---->
<!--    console.log(bolt.walk(60));-->
<!--//    console.log('HELLO MFCKR'.lucky);-->
<!--//    console.log(human3.walk(60), human2.walk(60));-->
<!--//-->
<!--//    console.log(human1.test, human2.test, human3.test);-->
<!---->
<!--//    for (key in human1) {-->
<!--//        console.log(key, human1.hasOwnProperty(key))-->
<!--//-->
<!--//    }-->
<!--//    console.log(human1.hasOwnProperty('test'));-->
<!---->
<!---->
<!--//    alert(summator(2));-->
<!--//    alert(summator(4));-->
<!--</script>-->

<!--<script>-->
<!--    var first = function () {-->
<!--        console.log('firstFunc');-->
<!--    };-->
<!---->
<!--    var interval = setInterval(first, 1000);-->
<!---->
<!--    var clear = function () {-->
<!--        clearInterval(interval);-->
<!--    };-->
<!---->
<!--    setTimeout(clear, 5000);-->
<!---->
<!--    console.log('secondMes');-->
<!--//    alert('third');-->
<!--</script>-->

<!--<script>-->
<!--    $(document).on('DOMContentLoaded', function (e) {-->
<!--        console.log(e);-->
<!--    });-->
<!--    $(function (e) {-->
<!--        console.log(e);-->
<!--    });-->
<!--</script>-->

<a href="#" id="link">test</a>
<script>
    $(function () {
//        var $links = $('a')
        $('a')
            .on('mouseenter', function () {
                $(this).css('background-color', 'red');
            })
            .on('mouseleave', function () {
                $(this).css('background-color', 'transparent');
            });
        $('#link').click(function (e) {
            e.preventDefault();
            alert('NO, MFCKR!');
        })

    });
</script>