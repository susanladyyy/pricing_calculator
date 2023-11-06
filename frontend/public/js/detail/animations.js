$(document).ready(function () {
    const tabLinks = document.querySelectorAll("[data-tab]");
    const tabTabs = document.querySelectorAll(".tab-tab");
    const tabContents = document.querySelectorAll(".tab-content");

    tabLinks.forEach((tabLink) => {
        tabLink.addEventListener("click", function () {
            const targetTab = this.dataset.tab;

            tabContents.forEach((content) => {
                content.style.display =
                    content.id === targetTab ? "block" : "none";
            });

            tabTabs.forEach((tabTab) => {
                if (tabTab.id === `tab-${targetTab}`) {
                    tabTab.classList.add(
                        "bg-primary",
                        "hover:bg-secondary-600"
                    );
                    tabTab.classList.remove(
                        "bg-disabled-300",
                        "hover:bg-disabled-200"
                    );
                } else {
                    tabTab.classList.remove(
                        "bg-primary",
                        "hover:bg-secondary-600"
                    );
                    tabTab.classList.add(
                        "bg-disabled-300",
                        "hover:bg-disabled-200"
                    );
                }
            });
        });
    });

    // Function to show the selected tab and set it in localStorage
    function showTab(tabId) {
        $(".nav-body").hide();
        $("#" + tabId).show();

        $(".nav-item").removeClass("selected-tab font-bold text-xl");
        $('[data-tab="' + tabId + '"]').addClass(
            "selected-tab font-bold text-xl"
        );

        var lastSelectedTab = localStorage.getItem('lastSelectedTab');

        console.log(lastSelectedTab)
        if(lastSelectedTab) {
            $(`[data-tab="${lastSelectedTab}"]`).click();
        }

        // Save the selected tab in localStorage
        localStorage.setItem("selectedTab", tabId);
    }

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    $(".nav-item").click(function () {
        const tab = $(this).data("tab");
        showTab(tab);
        scrollToTop();
    });

    $(".continue-to").click(function () {
        const tab = $(this).data("tab");
        showTab(tab);
        scrollToTop();
    });

    // Retrieve the selected tab from localStorage and show it
    const selectedTab = localStorage.getItem("selectedTab");
    if (selectedTab) {
        showTab(selectedTab);
    }

    $("input").on("keypress", function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });
});
