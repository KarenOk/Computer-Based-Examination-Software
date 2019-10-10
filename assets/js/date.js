
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
