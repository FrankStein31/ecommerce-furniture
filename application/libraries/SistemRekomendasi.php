<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * PHP item based filtering
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * @package   PHP item based filtering
 */

class SistemRekomendasi {
  //fungsi untuk mencari persamaan antara user 1 dengan user yang lain
  //matrix itu data yang sudah dikelompokkan berdasarkan rating dari masing-masing user
  function similarity_distance($matrix,$person1,$person2)
  {
    //array untuk menampung data
    $similar=array();
    $sum=0;
    //foreach istilahnya perulangan untuk mencari matrix data berdasarkan user
    foreach($matrix[$person1] as $key=> $value)
    {
      //digunakan untuk mengecek persamaan antara user 1 dengan user yg lain
      if(array_key_exists($key,$matrix[$person2]))
      {
        //fungsi similar key untuk menanmpung data dr persamaan antar user 1 dgn yg lain
        $similar[$key]=1;
      }
    }  
      if($similar==0)
      {
        return 0;
      }
      //untuk mengolah nilai similarity dari setiap user
    foreach($matrix[$person1] as $key=> $value)
    {
      if(array_key_exists($key,$matrix[$person2]))
      {
        $sum=$sum+pow($value-$matrix[$person2][$key],2);
      }
    }  
    //proses pengakaran dr hasil nilai sum diatas
    return 1/(1+sqrt($sum));
  }  
    //untuk menentukan sistem rekomendasinya
  function getRecommendation($matrix,$person)
  {
    $total=array();
    $simsum=array();
    $ranks=array();
    
    foreach($matrix as $otherperson=>$value)
    {
      if($otherperson!=$person)
      {
        //sim untuk memanggil fungsi similarity distance untuk menentukan nilai dari matrix atau data dari rating user
        $sim=$this->similarity_distance($matrix,$person,$otherperson);
        
        foreach($matrix[$otherperson] as $key=>$value)
        {
          if(!array_key_exists($key,$matrix[$person]))
          {
            if(!array_key_exists($key,$total))
            {
              $total[$key]=0;
            }
            $total[$key]+=$matrix[$otherperson][$key]*$sim;
            
            if(!array_key_exists($key,$simsum))
            {
              $simsum[$key]=0;
            }
            $simsum[$key]+=$sim;
          }
        }
      }
    }
    //untuk hasil akhirnya key berdasarkan index user 
    foreach($total as $key=>$value)
    {
      $ranks[$key]=$value/$simsum[$key];
      
    }
    //diurutkan berdasarkan rankingnya array yang paling tinggi hasilnya
    array_multisort($ranks,SORT_DESC);
      return $ranks;
  }
}
?>