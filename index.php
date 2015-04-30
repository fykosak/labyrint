<?php

mb_internal_encoding("UTF-8");
//require './data.php';

echo '<meta charset="UTF-8">';

$mysqli = new mysqli;
$mysqli->mysqli('localhost', 'root', 'fykos1', 'labyrint_jar_2015', null, null);
$mysqli->query("SET NAMES 'utf8'");
$mysqli->query('SET CHARACTER SET utf8');


$lab_jaro_2015 = new labyrint();



$res = $mysqli->query('SELECT * FROM `stand`;');



while ($obj = $res->fetch_object()) {
    $id = $obj->stand_id;
    $stan = new stanoviste($id, $obj->label, $obj->question);
    $com = 'select * from path p where `from`=' . $id;

    $stand_res = $mysqli->query($com);

    while ($obj_stand = $stand_res->fetch_object()) {
        $stan->_add_direction(new direction($obj_stand->to, $obj_stand->answer));
    }

    $lab_jaro_2015->_add_stanoviste($stan);
}










$tex = $lab_jaro_2015->_print_lab();
file_put_contents('otazky.tex', $tex);

class labyrint {

    private $data;

    public function __construct() {
        
    }

    public function _add_stanoviste(stanoviste $stan) {
        $this->data[] = $stan;
    }

    public function find_alphabet($id) {
        foreach ($this->data as $value) {

            if ($value->stan['ID'] == $id) {
                return $value->stan['alphabeth'];
            }
        }
        var_dump($id);

        return 'null';
    }

    public function _print_lab($opt = "tex") {
        $r = "";
        foreach ($this->data as $key => $value) {
            $r.='
{\begin{center}
\scalebox{16}{
' . $value->stan['alphabeth'] . '
}

\end{center}
}\vspace{3\baselineskip}
\hspace{-3em}
\noindent
\scalebox{3}{%
\begin{minipage}{0.33\textwidth}
' . $value->stan['text']
                    . '%
\end{minipage}}%
        
\vspace{3\baselineskip}
\scalebox{3}{%
\hspace{-3em}%
\begin{minipage}{0.33\textwidth}
\begin{compactenum}[a)]
';
            $s = array();
            foreach ($value->stan['direction'] as $v) {
                $id = $v->dir['ID'];

                $s[] = '\item[' . $this->find_alphabet($id) . ':]{' . $v->dir['answer'] . '}
                      ';
            }
            shuffle($s);
            foreach ($s as $value) {
                $r.=$value;
            }

            $r.='
\end{compactenum}

\end{minipage}
}
\newpage';
        }

        return $r;
    }

}

class stanoviste {

    public $stan = array(
        'ID' => null,
        'alphabeth' => null,
        'text' => null,
        'direction' => array()
    );

    public function __construct($id, $alpha, $text) {
        $this->stan['ID'] = $id;
        $this->stan['alphabeth'] = $alpha;
        $this->stan['text'] = $text;
    }

    public function _add_direction(direction $dir) {
        $this->stan['direction'][] = $dir;
    }

}

class direction {

    public $dir = array(
        'ID' => null,
        'answer' => null
    );

    public function __construct($id, $ans) {
        $this->dir['ID'] = $id;
        $this->dir['answer'] = $ans;
    }

}
