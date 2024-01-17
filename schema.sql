create or replace table wp_wporg_gp_translation_events_actions
(
    event_id       int(10)     not null comment 'ID of the event',
    user_id        int(10)     not null comment 'ID of the user who authored the translation',
    translation_id int(10)     not null comment 'ID of the translation',
    occurred_at    datetime    not null comment 'When the action occurred, in UTC',
    locale         varchar(10) not null comment 'Locale of the translation'
)
    comment 'Tracks translations that were created during a translation event';

create index wp_wporg_gp_translation_events_actions_event_id_index
    on wordpress.wp_wporg_gp_translation_events_actions (event_id);

create index wp_wporg_gp_translation_events_actions_occurred_at_index
    on wordpress.wp_wporg_gp_translation_events_actions (occurred_at);

create index wp_wporg_gp_translation_events_actions_user_id_index
    on wordpress.wp_wporg_gp_translation_events_actions (user_id);
