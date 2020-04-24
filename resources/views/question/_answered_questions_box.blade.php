<div class="info-box bg-green">
    <span class="info-box-icon"><i class="fa fa-question"></i></span>
    <div class="info-box-content">
        <span class="info-box-text">Questions</span>
        <span class="info-box-number">{{ $answered_questions }}</span>

        <div class="progress">
            <div class="progress-bar" style="width: {{ $percentage_of_answered_questions }}%"></div>
        </div>
        <span
            class="progress-description">You have answered {{ $percentage_of_answered_questions }}% of the questions</span>
    </div>
</div>
