var num_secs;
var num_timerID = null;
var num_timerRunning = false;
var num_delay = 1000;
var num_clear = true;

function num_InitializeTimer()
{
    // Set the length of the timer, in seconds
    num_secs = 5;
	num_clear = false;
    num_StopTheClock();
    num_StartTheTimer();
}

function num_StopTheClock()
{
    if(num_timerRunning) {
        clearTimeout(num_timerID);
	}
    num_timerRunning = false;
}

function num_StartTheTimer()
{
    if (num_secs==0)
    {
	   num_StopTheClock();
       num_clear = true;
    }
    else
    {
        num_secs = num_secs - 1;
        num_timerRunning = true;
        num_timerID = self.setTimeout("num_StartTheTimer()", num_delay);
    }
}


