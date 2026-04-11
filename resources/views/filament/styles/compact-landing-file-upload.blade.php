{{-- Только страница редактирования секции лендинга: ужимает FilePond до мини-сетки --}}
@if (request()->routeIs('filament.filament.resources.landing-sections.edit'))
    <style>
        .fi-fo-file-upload .filepond--root {
            margin-bottom: 0;
        }

        .fi-fo-file-upload .filepond--list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .fi-fo-file-upload .filepond--item {
            width: 5rem !important;
        }

        .fi-fo-file-upload .filepond--image-preview-wrapper,
        .fi-fo-file-upload .filepond--image-preview {
            height: 3.25rem !important;
            max-height: 3.25rem !important;
        }

        .fi-fo-file-upload .filepond--file {
            min-height: 3.75rem;
            padding: 0.2rem 0.3rem 0.35rem;
        }

        .fi-fo-file-upload .filepond--file-info {
            margin-top: 0.1rem !important;
        }

        .fi-fo-file-upload .filepond--file-info-main {
            font-size: 0.625rem;
            line-height: 1.15;
            max-width: 4.25rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .fi-fo-file-upload .filepond--file-info-sub {
            font-size: 0.55rem;
            line-height: 1.1;
        }

        .fi-fo-file-upload .filepond--file-action-button {
            transform: scale(0.88);
        }

        .fi-fo-file-upload .filepond--panel-root {
            min-height: 3.5rem !important;
        }
    </style>
@endif
