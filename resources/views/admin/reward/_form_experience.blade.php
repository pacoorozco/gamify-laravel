<x-forms.form method="post" :action="route('admin.rewards.experience')">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-person-up"></i>
                {{ __('admin/reward/messages.give_experience') }}
            </h3>
        </div>
        <div class="card-body">

            <!-- username -->
            <x-forms.select name='username'
                            :label="__('admin/reward/messages.username')"
                            :placeholder="__('admin/reward/messages.pick_user')"
                            :options="$users"
                            class="username-input"
                            :required="true"/>
            <!-- ./ username -->

            <!-- points -->
            <x-forms.select name='points'
                            :label="__('admin/reward/messages.points')"
                            :placeholder="__('admin/reward/messages.pick_badge')"
                            :options="[
                '5' => __('admin/reward/messages.points_value', ['points' => '5']),
                '10' => __('admin/reward/messages.points_value', ['points' => '10']),
                '25' => __('admin/reward/messages.points_value', ['points' => '25']),
                ]"
                            value="5"
                            :required="true"/>
            <!-- ./ points -->

            <!-- message -->
            <x-forms.textarea name="message"
                              :label="__('admin/reward/messages.why_u_reward')"
                              :required="true"/>
            <!-- ./ message -->
        </div>
        <div class="card-footer">
            <x-forms.submit type="primary" :value="__('admin/reward/messages.give_experience')"/>
        </div>
    </div>

</x-forms.form>



