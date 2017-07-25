var calendar = {

    init: function(ajax) {

        if (ajax) {

            function GetMonthName(monthNumber) {
                var months = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
                return months[monthNumber - 1];
            }
            // ajax call to print json
            $.ajax({
                url: '/api/shedule/get-events',
                type: 'GET',
            })
                .done(function(data) {
                    var events = data.events;

                    // loop json & append to dom
                    for (var i = 0; i < events.length; i++) {
                        $('.b-shedule').append(
                            '<div class="b-event" date-day="'
                            + events[i].day
                            +'" date-month="' + events[i].month
                            +'" date-year="'+ events[i].year
                            +'" date-id="'+ events[i].id
                            +'" date-lang="'+ events[i].lang
                            +'" data-number="'+ i +'">'
                            +'<h2 class="b-event__title">'+events[i].title+'</h2>'
                            +'<div class="b-event__date">'
                            + events[i].day + ' '
                            + GetMonthName(events[i].month) + ' '
                            + events[i].year  + ' года'
                            +'</div>'
                            +'<div class="b-event__description">'
                            +'<span>Расписание:</span>'
                            +'<ul class="b-event__list">'+ events[i].description +'</ul>'
                            +'<div class="b-event__address"><span>Адрес: </span>'+events[i].address+'</div>'
                            +'<div class="b-event__speaker"><span>Семинар проводит: </span>'+events[i].speaker+'</div>'
                            +'</div>'
                            +'<div class="b-event__action">'
                            +'<a href="'+events[i].link+'" class="btn btn--inline">Узнать больше</a>'
                            +'</div>');
                    }

                    // start calendar
                    calendar.startCalendar();

                })
                .fail(function(data) {
                    console.log(data);
                });
        } else {

            // if not using ajax start calendar
            calendar.startCalendar();
        }

    },

    startCalendar: function() {
        var mon  = 'Пн.';
        var tue  = 'Вт.';
        var wed  = 'Ср.';
        var thur = 'Чт.';
        var fri  = 'Пт.';
        var sat  = 'Сб.';
        var sund = 'Вс.';

        /**
         * Get current date
         */
        var d = new Date();
        var strDate = yearNumber + "/" + (d.getMonth() + 1) + "/" + d.getDate();
        var yearNumber = (new Date).getFullYear();
        /**
         * Get current month and set as '.current-month' in title
         */
        var monthNumber = d.getMonth() + 1;

        function GetMonthName(monthNumber) {
            var months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
            return months[monthNumber - 1];
        }

        setMonth(monthNumber, mon, tue, wed, thur, fri, sat, sund);

        function setMonth(monthNumber, mon, tue, wed, thur, fri, sat, sund) {
            $('.month').html('<span>' + GetMonthName(monthNumber) + '</span> ' + yearNumber);
            $('.month').attr('data-month', monthNumber);
            printDateNumber(monthNumber, mon, tue, wed, thur, fri, sat, sund);
        }

        $('.btn-next').on('click', function(e) {
            var monthNumber = $('.month').attr('data-month');
            if (monthNumber > 11) {
                $('.month').attr('data-month', '0');
                var monthNumber = $('.month').attr('data-month');
                yearNumber = yearNumber + 1;
                setMonth(parseInt(monthNumber) + 1, mon, tue, wed, thur, fri, sat, sund);
            } else {
                setMonth(parseInt(monthNumber) + 1, mon, tue, wed, thur, fri, sat, sund);
            };
        });

        $('.btn-prev').on('click', function(e) {
            var monthNumber = $('.month').attr('data-month');
            if (monthNumber < 2) {
                $('.month').attr('data-month', '13');
                var monthNumber = $('.month').attr('data-month');
                yearNumber = yearNumber - 1;
                setMonth(parseInt(monthNumber) - 1, mon, tue, wed, thur, fri, sat, sund);
            } else {
                setMonth(parseInt(monthNumber) - 1, mon, tue, wed, thur, fri, sat, sund);
            };
        });

        /**
         * Get all dates for current month
         */

        function printDateNumber(monthNumber, mon, tue, wed, thur, fri, sat, sund) {

            $($('tbody.event-calendar tr')).each(function(index) {
                $(this).empty();
            });

            $($('thead.event-days tr')).each(function(index) {
                $(this).empty();
            });

            function getDaysInMonth(month, year) {
                // Since no month has fewer than 28 days
                var date = new Date(year, month, 1);
                var days = [];
                while (date.getMonth() === month) {
                    days.push(new Date(date));
                    date.setDate(date.getDate() + 1);
                }
                return days;
            }

            i = 0;

            setDaysInOrder(mon, tue, wed, thur, fri, sat, sund);

            function setDaysInOrder(mon, tue, wed, thur, fri, sat, sund) {
                $('thead.event-days tr').append('<td>' + mon + '</td><td>' + tue + '</td><td>' + wed + '</td><td>' + thur + '</td><td>' + fri + '</td><td>' + sat + '</td><td>' + sund + '</td>');
            };
            function getMonthDayIndex(month, year) {
                var weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                var monthDay = getDaysInMonth(month, year)[0].toString().substring(0, 3);
                var index = 0;

                index = weekDays.indexOf(monthDay);
                return index;
            };

            var startDay = false;
            $(getDaysInMonth(monthNumber - 1, yearNumber)).each(function(index) {
                i++;
                var index = index + 1;
                var dayNumber = getMonthDayIndex(monthNumber - 1, yearNumber);

                if ( index <= dayNumber && !startDay ){
                    for ( var k=1; k<=dayNumber; k++,i++ ){
                        $('tbody.event-calendar tr.1').append('<td></td>');
                    }
                    startDay = true;
                }

                if (i < 8) {
                    $('tbody.event-calendar tr.1').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                } else if (i < 15) {
                    $('tbody.event-calendar tr.2').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                } else if (i < 22) {
                    $('tbody.event-calendar tr.3').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                } else if (i < 29) {
                    $('tbody.event-calendar tr.4').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                } else if (i < 36) {
                    $('tbody.event-calendar tr.5').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                }
            });
            var date = new Date();
            var month = date.getMonth() + 1;
            var thisyear = new Date().getFullYear();
            setCurrentDay(month, thisyear);
            setEvent();
            displayEvent();
        }

        /**
         * Get current day and set as '.current-day'
         */
        function setCurrentDay(month, year) {
            var viewMonth = $('.month').attr('data-month');
            var eventYear = $('.event-days').attr('date-year');
            if (parseInt(year) === yearNumber) {
                if (parseInt(month) === parseInt(viewMonth)) {
                    $('tbody.event-calendar td[date-day="' + d.getDate() + '"]').addClass('current-day');
                }
            }
        };

        /**
         * Add class '.active' on calendar date
         */
        $('tbody td').on('click', function(e) {
            if ($(this).hasClass('event')) {
                $('tbody.event-calendar td').removeClass('active');
                $(this).addClass('active');
            } else {
                $('tbody.event-calendar td').removeClass('active');
            };
        });

        /**
         * Add '.event' class to all days that has an event
         */
        function setEvent() {
            $('.b-event').each(function(i) {
                var eventID = $(this).attr('date-id');
                var eventLang = $(this).attr('date-lang');
                var eventMonth = $(this).attr('date-month');
                var eventDay = $(this).attr('date-day');
                var eventYear = $(this).attr('date-year');
                var eventClass = $(this).attr('event-class');
                if (eventClass === undefined) eventClass = 'event';
                else eventClass = 'event ' + eventClass;

                if (parseInt(eventYear) === yearNumber) {
                    var $event = $('tbody.event-calendar tr td[date-month="' + eventMonth + '"][date-day="' + eventDay + '"]');
                    $event.html($event.text());
                    $event.addClass(eventClass);
                }
            });
        };

        /**
         * Get current day on click in calendar
         * and find b-event to display
         */
        function displayEvent() {
            $('tbody.event-calendar td').on('click', function(e) {
                $('.b-event').slideUp(600);
                var monthEvent = $(this).attr('date-month');
                var dayEvent = $(this).text();
                $('.b-event[date-month="' + monthEvent + '"][date-day="' + dayEvent + '"]').slideDown(600);
            });
        };

        /**
         * Close b-event
         */
        $('.close').on('click', function(e) {
            $(this).parent().slideUp('fast');
        });

        /**
         * Save & Remove to/from personal list
         */
        $('.save').click(function() {
            if (this.checked) {
                $(this).next().text('Remove from personal list');
                var eventHtml = $(this).closest('.b-event').html();
                var eventMonth = $(this).closest('.b-event').attr('date-month');
                var eventDay = $(this).closest('.b-event').attr('date-day');
                var eventNumber = $(this).closest('.b-event').attr('data-number');
                $('.person-list').append('<div class="day" date-month="' + eventMonth + '" date-day="' + eventDay + '" data-number="' + eventNumber + '" style="display:none;">' + eventHtml + '</div>');
                $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"]').slideDown('fast');
                $('.day').find('.close').remove();
                $('.day').find('.save').removeClass('save').addClass('remove');
                $('.day').find('.remove').next().addClass('hidden-print');
                remove();
                sortlist();
            } else {
                $(this).next().text('Save to personal list');
                var eventMonth = $(this).closest('.b-event').attr('date-month');
                var eventDay = $(this).closest('.b-event').attr('date-day');
                var eventNumber = $(this).closest('.b-event').attr('data-number');
                $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').slideUp('slow');
                setTimeout(function() {
                    $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').remove();
                }, 1500);
            }
        });

        function remove() {
            $('.remove').click(function() {
                if (this.checked) {
                    $(this).next().text('Remove from personal list');
                    var eventMonth = $(this).closest('.day').attr('date-month');
                    var eventDay = $(this).closest('.day').attr('date-day');
                    var eventNumber = $(this).closest('.day').attr('data-number');
                    $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').slideUp('slow');
                    $('.b-event[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').find('.save').attr('checked', false);
                    $('.b-event[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').find('span').text('Save to personal list');
                    setTimeout(function() {
                        $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').remove();
                    }, 1500);
                }
            });
        }

        /**
         * Sort personal list
         */
        function sortlist() {
            var personList = $('.person-list');

            personList.find('.day').sort(function(a, b) {
                return +a.getAttribute('date-day') - +b.getAttribute('date-day');
            }).appendTo(personList);
        }

        /**
         * Print button
         */
        $('.print-btn').click(function() {
            window.print();
        });
    },

};

$(document).ready(function() {
    calendar.init('ajax');
});