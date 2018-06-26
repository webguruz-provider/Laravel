@extends('layouts.admin')
@section('content')
<header class="admin-content__header u-bg-white"><div class="admin-content__header-mast u-flex-center"><h2 class="admin-content__header-title">{{$questionDetails->name}}</h2> <div class="admin-content__header-actions"></div></div></header>
<div class="game-wrapper graph-wrapper">
    <!--game-wrapper--->
    <div class="row">
        <div class="col-lg-12">
            <!--custom chart start-->
            @if($hasServeyAns == 0)
                <div class="border-head">
                    <h3>There is no activity for this question yet.</h3>
                </div>
            @else
<?php if(isset($serveyResults)){
				if(count($serveyResults) >= 13){
					$newClass="overflow-bar";
				}else{
					$newClass="";
				}
			}?>
            <div class="custom-bar-chart {{$newClass}}">
			<table class="custom-inner {{$newClass}}">
			<tr>
			<td>
                <ul class="y-axis">
                    <?php
                        $interval = 5;
                        $range = 25;
						$heightMultipliyer = 3.6;
                        if($answered > 25){
                            $rangeMultiply = floor($answered/25);
                            $newRange = $range*$rangeMultiply;
                            $range = $range+$newRange;
                            $interval = $range/$interval;
							$heightMultipliyer = $heightMultipliyer/($rangeMultiply+1);
                        }
                        $barHeight = $range;
                        $newBarArray = array();
                        for($h = 0; $h<=$barHeight; $h+=$interval){
                            array_push($newBarArray, $h);
                        }
                        $size = sizeof($newBarArray);

                        for($hb=$size-1; $hb>=0; $hb--){
                        
                    ?>
                        <li>
                        <span>{{ $newBarArray[$hb] }}</span>
                        </li>
                    <?php } ?>
                </ul>
                <?php $i = 0; ?>
                @foreach($serveyResults as $result)
                    @if(count($result->serveyAnswers) >=1 )
                        <div class="bar">
                            <div class="value tooltips" data-original-title="{{ count($result->serveyAnswers) }}%" data-toggle="tooltip" data-placement="top" style="height: {{ count($result->serveyAnswers)*$heightMultipliyer }}%; background-color:{{ $colorArrays[$i] }};" onclick='resultDetail("{{$result->answer}}", {{ count($result->serveyAnswers) }}, {{ (count($result->serveyAnswers) / $answered)*100 }})'></div>
                        </div>
                    @endif
                     <?php 
                        $i++;
                        if($i % 12 == 0){
                            $i = 0;
                        }
                        
                    ?>
                @endforeach
                @if($questionDetails->allowed_other_answer == 1)
                    <div class="bar">
                        <div class="value tooltips" data-original-title="{{ $otherAnswersCount*$heightMultipliyer }}%; background-color:#ff00bf;" onclick='resultDetail("Other Answer", {{ $otherAnswersCount}}, {{ ($otherAnswersCount / $answered)*100 }})'></div>
                    </div>
                @endif
            </td>
			</tr>
			</table>
			</div>
            <!--custom chart end-->
            <div class="view-notify">
                <div class="col-md-6">
                    <label class="pull-right">
                        <span>Answered:</span>
                        <span></span>
                        <span>{{ $answered }}</span>
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="pull-left">
                        <span>Skipped:</span>
                        <span></span>
                        <span>{{ $skipped }}</span>
                    </label>
                </div>
            </div>
            <table class="table">
                <?php $j = 0; ?>
                @foreach($serveyResults as $result)
                    <tr>
                        <td><span style="background-color:{{ $colorArrays[$j] }};"></span></td>
                        <td>{{ $result->answer }}</td>
                        <td>{{ (count($result->serveyAnswers) / $answered)*100 }}%</td>
                        <td>{{ count($result->serveyAnswers) }}</td>
                    </tr>
                    <?php
                        $j++;
                        if($j % 12 == 0){
                            $j = 0;
                        }
                       
                    ?>
                @endforeach
               
                @if($questionDetails->allowed_other_answer == 1)
                    <tr>
                        <td><span style="background-color:#ff00bf;"></span></td>
                        <td>Other Answer</td>
                        <td>{{ round(($otherAnswersCount / $answered)*100, 2) }}%</td>
                        <td>{{ $otherAnswersCount }}</td>
                    </tr>
                @endif
                <tr>
                    <td></td>
                    <td>Total @if($answered == 1) Respondent @else Respondents @endif</td>
                    <td></td>
                    <td>{{ $answered }}</td>
                </tr>
            </table>
            @endif
        </div>
    </div>
</div>


 <!-- Modal -->
 <button style="display:none;" id="answer-details-servey-modal" type="button" data-toggle="modal" data-target="#serveyResultDetailPopup"></button>
  <div id="serveyResultDetailPopup" class="modal modal-box fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
            <h2 id="ans-name-servey"></h2>
            <p id="total-answered-servey"></p><br />
            <p id="total-percentage-servey"></p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>
  </div>
</div>
@endsection