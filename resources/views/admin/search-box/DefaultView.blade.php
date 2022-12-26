@extends('layout.dashboard')

@section('title')

@endsection

@section('content')
    <div class='row'>
        <div class="box">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <table class="table bordered table-response">
                    @php
                        $a = json_decode($results);
                        $numberOfColumns = count((array) $a[0]);
                    @endphp
                    
                        <tr>
                            @for($i=0;$i< $numberOfColumns; $i++)
                                <td>
                                    <?php $a = (array) $results[0] ?>
                                    <?php echo array_keys($a)[$i] ?>
                                </td>
                            @endfor
                        </tr>
                        
                    @foreach($results as $result)
                        <tr>
                            @for($i=0;$i< $numberOfColumns; $i++)
                                <td>
                                    <?php $a = (array) $result ?>
                                    <?php echo $a[array_keys($a)[$i]] ?>
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection