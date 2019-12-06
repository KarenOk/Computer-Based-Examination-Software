
let days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
let greetingElem = document.querySelector(".greeting");
let timeElem = document.querySelector(".time");
let greeting, time;
let date = new Date();
let hours = date.getHours();

if (hours >= 0 && hours < 12) {
    greeting = "Good morning,";
} else if (hours >= 12 && hours < 17) {
    greeting = "Good afternoon,";
} else {
    greeting = "Good evening,";
}

time = `${days[date.getDay()]} <br> ${date.toLocaleDateString()} <br> ${date.toLocaleTimeString()}`

greetingElem.innerHTML = greeting;
timeElem.innerHTML = time;





// var tday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
// var tmonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
//     "November", "December"
// ];

// function GetClock() {
//     var d = new Date();
//     var nday = d.getDay(),
//         nmonth = d.getMonth(),
//         ndate = d.getDate(),
//         nyear = d.getFullYear();
//     var nhour = d.getHours(),
//         nmin = d.getMinutes(),
//         ap;
//     if (nhour == 0) {
//         ap = " AM";
//         nhour = 12;
//     } else if (nhour < 12) {
//         ap = " AM";
//     } else if (nhour == 12) {
//         ap = " PM";
//     } else if (nhour > 12) {
//         ap = " PM";
//         nhour -= 12;
//     }

//     if (nmin <= 9) nmin = "0" + nmin;

//     var clocktext = "" + tday[nday] + ", <br> " + tmonth[nmonth] + " " + ndate + ", " + nyear + " <br> " +
//         nhour + ":" + nmin + ap + "";
//     document.getElementById('clockbox').innerHTML = clocktext;
// }









// var tday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
// var tmonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
//     "November", "December"
// ];

// function GetClock(d, format) {

//     // FORMATS 
//     //  -- text-br = text with line breaks
//     //  -- text = text with line breaks
//     //  -- d/m/y-gr = 23/45/1964 with greeting

//     var nday = d.getDay(),
//         nmonth = d.getMonth(),
//         ndate = d.getDate(),
//         nyear = d.getFullYear();
//     var nhour = d.getHours(),
//         nmin = d.getMinutes(),
//         nsec = d.getSeconds(),
//         ap;
//     var greeting, clocktext;
//     if (nhour == 0) {
//         ap = " AM";
//         nhour = 12;
//     } else if (nhour < 12) {
//         ap = " AM";
//     } else if (nhour == 12) {
//         ap = " PM";
//     } else if (nhour > 12) {
//         ap = " PM";
//         nhour -= 12;
//     }

//     if (nmin <= 9) nmin = "0" + nmin;
//     if (nsec <= 9) nsec = "0" + nsec;

//     if (hours >= 0 && hours < 12) {
//         greeting = "Good morning,";
//     } else if (hours >= 12 && hours < 17) {
//         greeting = "Good afternoon,";
//     } else {
//         greeting = "Good evening,";
//     }

//     if (format === "text") {
//         clocktext = "" + tday[nday] + ", " + tmonth[nmonth] + " " + ndate + ", " + nyear + " <br>" +
//             nhour + ":" + nmin + ap + "";
//     } else if (format === "text-br") {
//         locktext = "" + tday[nday] + ", <br> " + tmonth[nmonth] + " " + ndate + ", " + nyear + " <br> " +
//             nhour + ":" + nmin + ap + "";
//     } else if (format === "d/m/y-gr") {
//         // clocktext = `${tday[nday]} <br> ${date.toLocaleDateString()} <br> ${date.toLocaleTimeString()}`
//         clocktext = tday[nday] + "<br>" + ndate + "/" + (nmonth + 1) + "/" + nyear + "<br> " + nhour + ":" + nmin + ":" + nsec + ap + "";
//     }

//     console.log(clocktext);

//     return clocktext;

// }
