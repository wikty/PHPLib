<?php
    include_once "class.db_connect.inc.php";
    include_once "class.event.inc.php";
    class Calendar extends DB_Connect
    {
        private $_useDate;
        private $_m;
        private $_y;
        private $_daysInMonth;
        private $_startDay;
        public function __construct($db=null,$_useDate=null)
        {
            parent::__construct($db);
            if(isset($_useDate))
            {
                $this->_useDate=$_useDate;
            }
            else
            {
                $this->_useDate=date("Y-m-d H:i:s");
            }
            $ts=strtotime($this->_useDate);
            $this->_m=date('m',$ts);
            $this->_y=date('Y',$ts);
            $this->_daysInMonth=cal_days_in_month(CAL_GREGORIAN,$this->_m,$this->_y);
            $ts=mktime(0,0,0,$this->_m,1,$this->_y);
            $this->_startDay=date('w',$ts);
            
            
        }
        private function _loadEventsInfo($id=null)
        {
        //get events info from db, return assoc array.
            $cmd="select event_id,event_title,event_desc,event_start,event_end from events ";
            if(empty($id))
            {
                $ts1=mktime(0,0,0,$this->_m,1,$this->_y);
                $ts2=mktime(23,59,59,$this->_m+1,0,$this->_y);
                $startDate=date("Y-m-d H:i:s",$ts1);
                $endDate=date("Y-m-d H:i:s",$ts2);
                $cmd.="where event_start between '".$startDate."' and '".$endDate."' order by event_start";
            }
            else
            {
                $cmd.="where event_id=:id limit 1";
            }
            //var_dump($cmd);
            try
            {
                $ctrl=$this->db->prepare($cmd);
                if(!empty($id))
                {
                    $ctrl->bindParam(":id",$id,PDO::PARAM_INT);
                }
                $ctrl->execute();//调用出错了
                $results=$ctrl->fetchAll(PDO::FETCH_ASSOC);
                //$results=$this->db->query($cmd);
                $ctrl->closeCursor();
                //echo var_dump($results);
                return $results;
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }
        }
        private function _loadEventById($id)
        {
            if(empty($id))
            {
                return null;
            }
            $events=$this->_loadEventsInfo($id);
            if(isset($events[0]))
            {
                $event=new Event($events[0]);
                return $event;
            }
            else
            {
                return null;
            }
        }
        private function _createEventsObj()
        {
        //events assoc array to event object array
            $events=$this->_loadEventsInfo();
            $eventsObj=array();
            //var_dump($events);
            try
            {
                foreach($events as $event)
                {
                    $dayth=date('j',strtotime($event['event_start']));
                    $eventsObj[$dayth][]=new Event($event);
                }
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }
            return $eventsObj;
        }
        public function buildCalendar()
        {
            $cal_m_y=date("F Y",strtotime($this->_useDate));
            $cal_id=date("Y-m",strtotime($this->_useDate));
            $weekdays=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
            $events=$this->_createEventsObj();
            //echo var_dump($events);
            $html="\n<h2 id='month-".$cal_id."'>$cal_m_y</h2>";
            for($i=0,$wdys=null;$i<7;$i++)
            {
                $wdys.="<li>".$weekdays[$i]."</li>";
            }
            $html.="\n<ul class='weekdays'>$wdys</ul>";
            //above:title and weekdays
            $html.="\n<ul>";
            for($j=1,$c=1,$t=date('j'),$m=date('m'),$y=date('Y');$c<=$this->_daysInMonth;$j++)
            {
                $class=($j<=$this->_startDay? 'fill':null);
                if($t==$c&&$m==$this->_m&&$y==$this->_y)
                {
                    $class.=" today";
                }
                $ls=sprintf("<li class='%s'>",$class);
                $le="</li>";
                
                if($j>$this->_startDay&&$c<=$this->_daysInMonth)
                {
                    
                    $event_info=null;
                    if(isset($events[$c]))
                    {
                        foreach($events[$c] as $event)
                        {
                            $event_info.="<a href='view.php?event_id=".$event->id."'>".stripslashes($event->title)."</a>";
                        }
                        //echo $event_info;
                    }
                    $date=sprintf("<strong>%02d</strong>",$c++);
                }
                else
                {
                    $date="&nbsp;";
                }
                
                $wrap=($j%7==0? "</ul>\n<ul>":null);
                $html.=$ls.$date.$event_info.$le.$wrap;
            }
            
            while($j%7!=1)
            {
                $html.="<li class='fill'>&nbsp;</li>";
                $j++;
            }
            $html.="</ul>";
            $options=$this->_adminGeneralOptions();
            return $html.$options;
        }
        public function displayEvent($id)
        {
            $event=$this->_loadEventById($id);
            $ts=strtotime($event->start);
            $date=date("F d, Y",$ts);
            $start=date("g:ia",$ts);
            $end=date("g:ia",strtotime($event->end));
            $edit=$this->_adminEntryOptions($event->id);
            return "\n<h2>".stripslashes($event->title)."</h2>\n".
            "<p class='dates'>$date,$start&mdash;$end</p>\n".
            "<p>".stripslashes($event->description)."</p>\n".$edit;
        }
        public function displayForm()
        {
            $submit="Create Event";
            if(isset($_POST['event_id']))
            {
                $id=(int)$_POST['event_id'];
            }
            else
            {
                $id=null;
            }
            if(!empty($id))
            {
               $event=$this->_loadEventById($id);
               if(!is_object($event))
               {
                    return null;
               }
               $submit="Edit Event";
            }
            return<<<MYFORM
            <form action="asset/inc/process.inc.php" method="post" >
                <fieldset>
                    <legend>{$submit}</legend>
                </fieldset>
                <label for="event_title" >Event Title</label>
                    <input type="text" id="event_title" name="event_title" value="$event->title" />
                <label for="event_start">Event Start</label>
                    <input type="text" id="event_start" name="event_start" value="$event->start" />
                <label for="event_end">Event End</label>
                    <input type="text" id="event_end" name="event_end" id="event_end" value="$event->end" />
                <label fro="event_description">Event Description</label>
                    <textarea name="event_description" id="event_description">$event->description</textarea>
                <input type="hidden" name="event_id" value="$event->id" />
                <input type="hidden" name="token" value="$_SESSION[token]" />
                <input type="hidden" name="action" value="event_edit" />
                <input type="submit" name="event_submit" value="$submit" /> or <a href="./" >cancel</a>
            </form>
MYFORM;
        }
        public function processForm()
        {
            if($_POST['action']!="event_edit")
            {
                return "Access method is incorrectlly,shoul be by event_edit";
            }
            $title=htmlentities($_POST['event_title'],ENT_QUOTES);
            $desc=htmlentities($_POST['event_description'],ENT_QUOTES);
            $start=htmlentities($_POST['event_start'],ENT_QUOTES);
            $end=htmlentities($_POST['event_end'],ENT_QUOTES);
            if(!($this->_validDate($start))||!($this->_validDate($end)))
            {
                return "unvalidate date, use YYYY-mm-dd hh:mm:ss.";
            }
            if(empty($_POST['event_id']))
            {
                $cmd="insert into events(event_title,event_start,event_end,event_desc)
                values(:title,:start,:end,:desc)";
            }
            else
            {
                $id=(int)$_POST['event_id'];
                $cmd="update events set event_title=:title,event_start=:start,event_end=:end,event_desc=:desc
                where event_id=$id";
            }
            try
            {
                $ctrl=$this->db->prepare($cmd);
                $ctrl->bindParam(":title",$title,PDO::PARAM_STR);
                $ctrl->bindParam(":start",$start,PDO::PARAM_STR);
                $ctrl->bindParam(":end",$end,PDO::PARAM_STR);
                $ctrl->bindParam(":desc",$desc,PDO::PARAM_STR);
                $ctrl->execute();
                $ctrl->closeCursor();
                return $this->db->lastInsertId();
            }
            catch(Exception $e)
            {
                did($e->getMessage());
            }
        }
        private function _adminGeneralOptions()
        {
        if(isset($_SESSION['user']))
        {
            return <<<MYHTML
            <a href="admin.php" class="admin">+ Add New Event</a>
            <form class="admin" action="asset/inc/process.inc.php" method="post">
            <div>
                <input type="submit" value="Log Out" />
                <input type="hidden" value="$_SESSION[token]" name="token" />
                <input type="hidden" name="action" value="user_logout" />
            </div>
            </form>
MYHTML;
        }
        else
        {
            return "<a href='login.php' class='admin'>Log In</a>";
        }
        }
        
        
        private function _adminEntryOptions($id)
        {
        if(isset($_SESSION['user']))
        {
        return <<<MYHTML
        <div class="admin-options">
            <form action="admin.php" method="post">
            <p>
                <input type="submit" name="event_edit" value="Edit This Event" />
                <input type="hidden" name="event_id" value="$id" />
            </p>    
            </form>
            <form action="confirmdelete.php" method="post">
            <p>
                <input type="submit" name="event_delete" value="Delete This Event" />
                <input type="hidden" name="event_id" value="$id" />
            </p>
            </form>
        </div>
MYHTML;
        }
        else
        {
            return null;
        }
        }
        public function confirmDelete($id)
        {
            if(empty($id))
            {
                header("Location:./");
                return null;
            }
            $id=preg_replace("/[^0-9]/","",$id);
            if(isset($_POST['confirm_delete'])&&($_POST['token']==$_SESSION['token']))
            {
                if($_POST['confirm_delete']=="Yes, Delete It")
                {
                    $cmd="delete from events where event_id=:id limit 1";
                    try
                    {
                        $ctrl=$this->db->prepare($cmd);
                        $ctrl->bindParam(":id",$id,PDO::PARAM_INT);
                        $ctrl->execute();
                        $ctrl->closeCursor();
                        header("Location:./");
                        return;
                     }
                     catch(Exception $e)
                     {
                        die($e->getMessage());
                     }
                }
                else
                {
                    header("Location:./");
                    return;
                }
            }
            $event=$this->_loadEventById($id);
            if(!is_object($event))
            {
                header("Location:./");
                return;
            }
            return <<<MYHTML
            <form action="confirmdelete.php" method="post">
                <h2>Are you sure you want to delete <strong>$event->title</strong></h2>
                <p>There is <strong>no undo</strong> if you continue.</p>
                <p>
                <input type="submit" name="confirm_delete" value="Yes, Delete It" />
                <input type="submit" name="confirm_delete" value="Nope, Just Kiddiing!" />
                <input type="hidden" name="event_id" value="$event->id" />
                <input type="hidden" name="token" value="$_SESSION[token]" />
                </p>
            </form>
MYHTML;
        }
        private function _validDate($date)
        {
            $myreg="/^(\d{4}(-\d){2} \d{2}(:\d{2}){2})$/";
            return preg_match($myreg,$date)==1 ?true:false;
        }
    }
 ?>