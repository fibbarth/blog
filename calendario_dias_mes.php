    public function days()
    {
        $month = "12";
        $year = "2017";

        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);
        
        $daysWeek = array(
            '7',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
        );
        $x = 0;
        for($i=$start_time; $i<$end_time; $i+=86400)
        {
            $list[$x][date('N', $i)] = date('j', $i);
            if(date('N', $i) == 6) {
                $x++;
            }
        }

        return $list;
    }
