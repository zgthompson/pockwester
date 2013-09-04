package {
	import flash.events.MouseEvent;
	import flash.events.TimerEvent;
	import flash.utils.Timer;
	import flash.display.MovieClip;
	
	public class Fade extends MovieClip
	{
		private static const FADE_TIME:int = 1500;
		private static const FADE_DELTA:Number = 60/(FADE_TIME/2.0);
		
		private static var hasTrans:Boolean = false;
		private static var fadeTimer:Timer = null;
		
		public static var fadeTarget:String = '';
		public static var stageObject:MovieClip = null;
		public static var fadeObject:MovieClip = null;
				
		private static function fadeScreen(e:TimerEvent):void
		{
			if( fadeObject.alpha <= 1.0 && !hasTrans )
			{
				fadeObject.alpha += FADE_DELTA
				
				if( fadeObject.alpha >= 1.0 )
				{
					hasTrans = true;
					stageObject.gotoAndStop( fadeTarget );
					fadeTarget = "";
				}
			}
			else
			{
				fadeObject.alpha -= FADE_DELTA	
				
				if( fadeObject.alpha <= 0.0 )
				{
					fadeObject.alpha = 0.0;
					fadeTimer.stop();
					fadeTimer = null;
				}
			}
		}
			
		public static function NextScreen()
		{
			if( fadeTimer != null )
			{
				return;
			}
			
			fadeTimer = new Timer(60); // 1 second
			fadeTimer.addEventListener(TimerEvent.TIMER, fadeScreen);
			fadeTimer.start();
			hasTrans = false;
		}
	}
	
}
