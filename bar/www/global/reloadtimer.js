var secs;
var timerID = null;
var timerRunning = false;
var delay = 1000;

function InitializeTimer()
{
    // Set the length of the timer, in seconds
    secs = 30;
    StopTheClock();
    StartTheTimer();
}

function StopTheClock()
{
    if(timerRunning) {
        clearTimeout(timerID);
	}
    timerRunning = false;
}

function StartTheTimer()
{
    if (secs==0)
    {
        StopTheClock();
		switchLayer('list');
    }
    else
    {
        secs = secs - 1;
        timerRunning = true;
        timerID = self.setTimeout("StartTheTimer()", delay);
    }
}


