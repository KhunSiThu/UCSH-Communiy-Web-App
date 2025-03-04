let intervalId; // Variable to store the interval ID

setInterval(async () => {
    await getFriendList();
    await getUserGroup();
}, 1000)