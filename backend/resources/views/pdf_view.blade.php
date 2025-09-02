<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        h2 {
            color: #555;
            margin-top: 20px;
        }
        p {
            font-size: 14px;
        }
        .info {
            margin: 10px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .question {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .options {
            display: flex;
            justify-content: space-between; 
            margin-left: 20px;
        }
        .option {
            width: 45%;
            margin-bottom: 10px; 
        }
        .correct-answer {
            margin-top: 10px; 
            font-weight: bold; 
            color: green;
        }
    </style>
</head>
<body>
    
    <h1>{{ $title }}</h1>
     
    <h2>Details</h2>
    <hr>
    
    @if ($getAssignedUsers && $getAssignedUsers->count() > 0)
    @foreach ($getAssignedUsers as $val)
    @dd($val)
    <p class="info"><strong>Date:</strong> {{ $val->user_name }}</p>
    <p class="info"><strong>Name of Assigned Users:</strong> {{ $name }}</p>
    <p class="info"><strong>Date time:</strong> {{ $date . $time }}</p>
    
    <p class="info"><strong>Result:</strong> {{$result}}</p>
    <p class="info"><strong>Attempts:</strong> {{ $attempts }}</p>
    <p class="info"><strong>Completed:</strong> {{ $completed }}</p>
    
    <hr>
    @endforeach
    @endif
    <div class="footer">
        <p>&copy; {{ date('Y') }} CMS. All Rights Reserved.</p>
    </div>
    
    <!--<h1>{{ $title }}</h1>-->
    <!--<p class="info"><strong>Date:</strong> {{ date('m/d/Y') }}</p>-->
    
    <!--<h2>Details</h2>-->
    <!--<p class="info"><strong>Video URL:</strong> <a href="{{ $video_url }}">{{ $video_url }}</a></p>-->
    <!--<p class="info"><strong>Number of Questions to Ask:</strong> {{ $number_of_questions_to_ask }}</p>-->
    <!--<p class="info"><strong>Number of Correct Answers to Pass:</strong> {{ $number_of_correct_answer_to_pass }}</p>-->
    <!--<p class="info"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($due_date)->format('m/d/Y') }}</p>-->
    <!--<p class="info"><strong>Description:</strong> {{ $description ?: 'No description provided.' }}</p>-->

    <!--<h2>Questions</h2>-->
    <!--@if ($questions && $questions->count() > 0)-->
    <!--    @foreach ($questions as $question)-->
    <!--        <div class="question">-->
    <!--            <p><strong>Question:</strong> {{ $question->name }}</p>-->
    <!--            <div class="options">-->
    <!--                <div class="left-options">-->
    <!--                @foreach ($question->options->take(2) as $index => $option) -->
    <!--                    <div class="option">-->
    <!--                        {{ $index + 1 }}. {{ $option->name }} -->
    <!--                    </div>-->
    <!--                @endforeach-->
    <!--                </div>-->
    <!--                <div class="right-options">-->
    <!--                    @foreach ($question->options->slice(2) as $index => $option) -->
    <!--                        <div class="option">-->
    <!--                            {{ $index + 3 }}. {{ $option->name }} -->
    <!--                        </div>-->
    <!--                    @endforeach-->
    <!--                </div>-->

    <!--            </div>-->
    <!--            <div class="correct-answer">-->
    <!--                @foreach ($question->options as $option)-->
    <!--                    @if ($option->correct_answer == "1")-->
    <!--                        Correct Answer: {{ $option->name }}-->
    <!--                    @endif-->
    <!--                @endforeach-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    @endforeach-->
    <!--@else-->
    <!--    <p>No questions available.</p>-->
    <!--@endif-->

    <!--<h2>Additional Files</h2>-->
    <!--@if ($file)-->
    <!--    <p class="info"><strong>Download PDF:</strong> <a href="{{ url('storage/' . $file) }}" target="_blank">Download Toolbox Talk PDF</a></p>-->
    <!--@else-->
    <!--    <p class="info">No additional files available.</p>-->
    <!--@endif-->

    <!--<div class="footer">-->
    <!--    <p>&copy; {{ date('Y') }} Your Company Name. All Rights Reserved.</p>-->
    <!--</div>-->
</body>
</html>
