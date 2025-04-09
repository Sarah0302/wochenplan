jQuery(document).ready(function() {

    function getISOWeek(date) {
        let tempDate = new Date(date);
        tempDate.setHours(0, 0, 0, 0);
        tempDate.setDate(tempDate.getDate() + 3 - (tempDate.getDay() + 6) % 7);
        let week1 = new Date(tempDate.getFullYear(), 0, 4);
        return 1 + Math.round(((tempDate - week1) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
    }

    function workplace() {
        $(".job_container").each(function() {
            var $container = $(this);
            var columnIndex = $container.closest("td").index(); // Index der Spalte
            var $rowAbove = $container.closest("tr").prev(); // Die Zeile über der Job-Liste
            var $day = $rowAbove.find("td").eq(columnIndex); // Das td über der Liste
            var bgColor = "";
    
            // Falls keine Jobs in dieser Liste vorhanden sind → Setze Standardfarbe
            if ($container.find(".job_name_value").length === 0) {
                $day.removeClass("bg-lime-300 bg-cyan-300 bg-amber-300 bg-orange-300 bg-rose-300");
                return; // Nächste Iteration von .each()
            }
    
            // Überprüfe alle Job-Namen in dieser Liste
            $container.find(".job_name_value").each(function() {
                var jobText = $(this).val().toLowerCase(); // Kleinbuchstaben
    
                if (jobText.includes("fahrt")) {
                    bgColor = "bg-lime-300";
                } else if (jobText.includes("homeoffice")) {
                    bgColor = "bg-cyan-300";
                } else if (jobText.includes("kurzarbeit")) {
                    bgColor = "bg-amber-300";
                } else if (jobText.includes("halber tag")) {
                    bgColor = "bg-orange-300";
                } else if (jobText.includes("abwesend") || jobText.includes("schule")) {
                    bgColor = "bg-rose-300";
                }
            });
    
            // Hintergrundfarbe des Tages setzen
            $day.removeClass("bg-lime-300 bg-cyan-300 bg-amber-300 bg-orange-300 bg-rose-300");
            $day.addClass(bgColor);
        });
    }

    function workload() {
        $(".week_time").each(function() {
            var $dayCounter = $(this);
            var newDayVal = parseFloat($dayCounter.text()) || 0;
    
            // Tagesfarbe setzen
            $dayCounter.removeClass('bg-red-700 bg-yellow-700 bg-lime-700');
            if (newDayVal >= 7) {
                $dayCounter.addClass('bg-red-700');
            } else if (newDayVal >= 6) {
                $dayCounter.addClass('bg-yellow-500');
            } else if (newDayVal >= 1) {
                $dayCounter.addClass('bg-lime-700');
            } else {
                $dayCounter.removeClass('bg-red-700 bg-yellow-700 bg-lime-700');
            }
        });
    
        $(".personal_week").each(function() {
            var $weekCounter = $(this);
            var newWeekVal = parseFloat($weekCounter.text()) || 0;
    
            // Wochenfarbe setzen
            $weekCounter.removeClass('bg-red-700 bg-yellow-700 bg-lime-700');
            if (newWeekVal >= 40) {
                $weekCounter.addClass('bg-red-700');
            } else if (newWeekVal >= 32) {
                $weekCounter.addClass('bg-yellow-500');
            } else if (newWeekVal >= 0.1) {
                $weekCounter.addClass('bg-lime-700');
            } else {
                $weekCounter.removeClass('bg-red-700 bg-yellow-700 bg-lime-700');
            }
        });
    }    

    function timeCounter() {
        $(".job_container").each(function() {
            var $container = $(this);
            var columnIndex = $container.closest("td").index(); // Spalten-Index
            var $rowAbove = $container.closest("tr").prev(); // Die Zeile über der Job-Liste
            var $dayCounter = $rowAbove.find("td").eq(columnIndex).find(".week_time"); // Tages-Count-Element
            var $weekCounter = $rowAbove.find(".personal_week"); // Wochen-Count-Element
            var newDayVal = 0;
            var newWeekVal = 0;
    
            // Berechne Tageszeit für diese Spalte
            $container.find(".job_workload").each(function() {
                newDayVal += parseFloat($(this).val()) || 0;
            });
            $dayCounter.text(newDayVal.toFixed(2));
    
            // Berechne Wochenzeit für alle Tage dieser Person
            $rowAbove.find(".week_time").each(function() {
                newWeekVal += parseFloat($(this).text()) || 0;
            });
            $weekCounter.text(newWeekVal.toFixed(2));
        });
    }    

    function reset() {
        $(".job_name").val('');
        $(".job_time").val('');
        $(".job_safe").addClass("hidden");
    }

    function jobDone() {
        $(".job_box").each(function() {
            let $box = $(this);
            let $inputs = $box.find(".job_name_value, .job_workload");
            let $statusInput = $box.find("input[name='updateStatus']");
    
            if ($statusInput.val() === 'done') {
                $box.addClass("bg-lime-100");
                $inputs.prop("disabled", true);
            } else {
                $box.removeClass("bg-lime-100");
                $inputs.prop("disabled", false);
            }
        });
    }; 

    window.getWeekFromUrl = function() {
        var year = new Date().getFullYear();
        var month = new Date().getMonth();
        var day = new Date().getDate();
        var date = new Date(year, month, day); // Aktuelles Datum
        $thisWeek = getISOWeek(date);
        $weekURL = parseInt(new URLSearchParams(window.location.search).get("week"));
        $week = $weekURL || $thisWeek;

        return $week;
    }

    window.getMaxWeeks = function() {
        $year = new Date().getFullYear() // Aktuelles Jahr
        var date = new Date($year, 11, 28); // 28.12. liegt immer in der letzten KW

        $maxWeek = getISOWeek(date);
        return $maxWeek + 1; // Rückgabewert
    }

    window.openLists = function() {
        var openUser = []; // Array für geöffnete Benutzer
    
        $(".list-col").not(".show_pool").each(function() {
            var $container = $(this);
            var $rowAbove = $container.closest("tr").prev(); // Die Zeile über dem Container
            var user = $rowAbove.find(".personen_id").text(); // ID extrahieren
    
            if (!$container.hasClass("hidden")) {
                openUser.push(user); // Name zum Array hinzufügen
            }
        });
    
        // AJAX-Aufruf nach der Schleife
        $.ajax({
            url: "open-user.php",
            method: "POST",
            data: { openUser: openUser },
        });
    }
    
    window.addJob = function($container) {
        var jobName = $container.find(".job_name").val();

        if (jobName != '') {
            // Werte aus den Input-Feldern extrahieren
            $week = window.getWeekFromUrl();
            $url = "./wochenplan.php?week=";
            $url += $week;
            $url += "#user";
            var personen_id = $container.find("input[name='addPersonenId']").val();
            var day = $container.find("input[name='addDay']").val();
            var job = $container.find("input[name='addJob']").val();
            var time = $container.find("input[name='addTime']").val();
            var status = $container.find("input[name='addStatus']").val();

            // AJAX-Aufruf durchführen, um create.php mit der ID zu verwenden
            $.ajax({
                url: "create.php",
                method: "POST",
                data: {
                    personen_id: personen_id,
                    day: day,
                    job: job,
                    time: time,
                    status: status
                },
                success: function(response) {
                    window.location.href = $url;
                },
                error: function(xhr, status, error) {
                    alert("Fehler beim Hinzufügen: " + error); // Zeigt den Fehler an
                }
            });
        }
    }

    window.duplicateJob = function(jobName, jobTime, jobPerson, jobDay, jobStatus) {

        if (jobName != '') {
            $week = window.getWeekFromUrl();
            $url = "./wochenplan.php?week=";
            $url += $week;
            $url += "#user";

            // AJAX-Aufruf durchführen, um create.php mit der ID zu verwenden
            $.ajax({
                url: "create.php",
                method: "POST",
                data: {
                    personen_id: jobPerson,
                    day: jobDay,
                    job: jobName,
                    time: jobTime,
                    status: jobStatus
                },
                success: function(response) {
                    window.location.href = $url;
                },
                error: function(xhr, status, error) {
                    alert("Fehler beim Hinzufügen: " + error); // Zeigt den Fehler an
                }
            });
        }
    }

    window.updateJob = function($box) {
        $week = window.getWeekFromUrl();
        $url = "./wochenplan.php?week=";
        $url += $week;
        $url += "#user";
        let updateId = $box.attr("id");
        let updatePerson = $box.find("input[name='updatePerson']").val();
        let updateDay = $box.find("input[name='updateDay']").val();
        let updateJob = $box.find("input[name='updateJob']").val();
        let updateTime = $box.find("input[name='updateTime']").val();
        let updateStatus = $box.find("input[name='updateStatus']").val();

        // AJAX-Aufruf durchführen, um update.php mit der ID zu verwenden
        $.ajax({
            url: "update.php",
            method: "POST",
            data: {
                updateid: updateId,
                updatePerson: updatePerson,
                updateDay: updateDay,
                updateJob: updateJob,
                updateTime: updateTime,
                updateStatus: updateStatus
            },
            success: function(response) {
                console.log("Update Response:", response);
                window.location.href = $url;
            },
            error: function(xhr, status, error) {
                console.error("Fehler beim Aktualisieren:", error);
                alert("Fehler beim Aktualisieren: " + error); // Zeigt den Fehler an
            }
        });
    }

    window.updateAll = function() {
        reset();
        timeCounter();
        workplace();
        workload();
        jobDone();
    }

    window.getData = function() {
        $week = window.getWeekFromUrl();
        $url = "?week=";
        $url += $week;
        $url += "#user";

        // AJAX-Aufruf durchführen, um Daten aus der Datenbank aktualisiert abzurufen (verkettet)
        $.ajax({ url: "read.php" + $url, method: "POST" }).done(function() {
            $.ajax({ url: "helpers.php" + $url, method: "POST" }).done(function() {
                $.ajax({
                    url: "table.php" + $url,
                    method: "POST",
                    success: function(response) {
                        $('table').find('tr:gt(0)').remove();
                        $('table').append(response);

                        window.updateAll();
                    },
                    error: function(xhr, status, error) {
                        console.error("Fehler beim Laden von table.php:", error);
                        alert("Fehler beim Laden von table.php: " + error);
                    }
                });
    
            }).fail(function(xhr, status, error) {
                console.error("Fehler beim Laden von helpers.php:", error);
                alert("Fehler beim Laden von helpers.php: " + error);
            });
    
        }).fail(function(xhr, status, error) {
            console.error("Fehler beim Laden von read.php:", error);
            alert("Fehler beim Laden von read.php: " + error);
        });
    }

    // Diese Funktion wird direkt nach dem Laden der Seite ausgeführt
    window.getData();
});