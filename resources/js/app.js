const THEME_STORAGE_KEY = 'rino-theme';
const ANNOUNCEMENT_STORAGE_KEY =
    'rino-dismissed-announcement';

const getSystemTheme = () => {
    return window.matchMedia(
        '(prefers-color-scheme: dark)'
    ).matches
        ? 'dark'
        : 'light';
};

const resolveTheme = (mode) => {
    return mode === 'system'
        ? getSystemTheme()
        : mode;
};

const applyTheme = (mode) => {
    const resolvedTheme =
        resolveTheme(mode);

    document.documentElement.dataset.theme =
        resolvedTheme;

    document.documentElement.dataset.themeMode =
        mode;

    document
        .querySelectorAll(
            '[data-theme-option]'
        )
        .forEach((button) => {
            const active =
                button.dataset.themeOption ===
                mode;

            button.setAttribute(
                'aria-pressed',
                active ? 'true' : 'false'
            );

            button.dataset.active =
                active ? 'true' : 'false';
        });
};

const initializeThemeState = () => {
    const root =
        document.documentElement;

    const allowSwitch =
        root.dataset.allowThemeSwitch ===
        'true';

    const defaultMode =
        root.dataset.defaultTheme ||
        'dark';

    let selectedMode =
        defaultMode;

    if (allowSwitch) {
        const storedMode =
            localStorage.getItem(
                THEME_STORAGE_KEY
            );

        if (
            storedMode === 'dark' ||
            storedMode === 'light' ||
            storedMode === 'system'
        ) {
            selectedMode =
                storedMode;
        }
    }

    applyTheme(selectedMode);

    window
        .matchMedia(
            '(prefers-color-scheme: dark)'
        )
        .addEventListener(
            'change',
            () => {
                const storedMode =
                    localStorage.getItem(
                        THEME_STORAGE_KEY
                    );

                const currentMode =
                    storedMode ||
                    defaultMode;

                if (
                    currentMode ===
                    'system'
                ) {
                    applyTheme(
                        'system'
                    );
                }
            }
        );
};

const initializeSimpleThemeToggle = () => {
    const button =
        document.querySelector(
            '[data-theme-toggle]'
        );

    if (!button) {
        return;
    }

    const sunIcon =
        button.querySelector(
            '[data-theme-light-icon]'
        );

    const moonIcon =
        button.querySelector(
            '[data-theme-dark-icon]'
        );

    const updateIcon = () => {
        const currentTheme =
            document.documentElement
                .dataset.theme;

        if (
            currentTheme === 'dark'
        ) {
            sunIcon?.classList.remove(
                'hidden'
            );

            moonIcon?.classList.add(
                'hidden'
            );

            button.setAttribute(
                'aria-label',
                'Switch to light theme'
            );

            button.setAttribute(
                'title',
                'Switch to light theme'
            );
        } else {
            sunIcon?.classList.add(
                'hidden'
            );

            moonIcon?.classList.remove(
                'hidden'
            );

            button.setAttribute(
                'aria-label',
                'Switch to dark theme'
            );

            button.setAttribute(
                'title',
                'Switch to dark theme'
            );
        }
    };

    updateIcon();

    button.addEventListener(
        'click',
        () => {
            const currentTheme =
                document.documentElement
                    .dataset.theme;

            const nextTheme =
                currentTheme === 'dark'
                    ? 'light'
                    : 'dark';

            localStorage.setItem(
                THEME_STORAGE_KEY,
                nextTheme
            );

            applyTheme(
                nextTheme
            );

            updateIcon();
        }
    );
};

const updateAnnouncementHeight = () => {
    const bar =
        document.querySelector(
            '[data-announcement-bar]'
        );

    const announcementHeight =
        bar ? 40 : 0;

    const headerHeight =
        64;

    const stackHeight =
        headerHeight +
        announcementHeight;

    document.documentElement.style
        .setProperty(
            '--rino-announcement-height',
            `${announcementHeight}px`
        );

    document.documentElement.style
        .setProperty(
            '--rino-top-stack-height',
            `${stackHeight}px`
        );
};

const initializeAnnouncementBar = () => {
    const bar =
        document.querySelector(
            '[data-announcement-bar]'
        );

    if (!bar) {
        updateAnnouncementHeight();

        return;
    }

    const announcementId =
        bar.dataset.announcementId;

    const dismissedId =
        localStorage.getItem(
            ANNOUNCEMENT_STORAGE_KEY
        );

    if (
        announcementId &&
        dismissedId ===
            announcementId
    ) {
        bar.remove();

        updateAnnouncementHeight();

        return;
    }

    updateAnnouncementHeight();

    const dismissButton =
        bar.querySelector(
            '[data-announcement-dismiss]'
        );

    if (dismissButton) {
        dismissButton.addEventListener(
            'click',
            () => {
                if (announcementId) {
                    localStorage.setItem(
                        ANNOUNCEMENT_STORAGE_KEY,
                        announcementId
                    );
                }

                bar.remove();

                updateAnnouncementHeight();
            }
        );
    }

    const codeButton =
        bar.querySelector(
            '[data-announcement-code]'
        );

    if (codeButton) {
        codeButton.addEventListener(
            'click',
            async () => {
                const code =
                    codeButton.dataset
                        .announcementCode;

                if (!code) {
                    return;
                }

                const originalText =
                    codeButton.textContent;

                try {
                    await navigator.clipboard
                        .writeText(code);

                    codeButton.textContent =
                        'Copied';

                    window.setTimeout(
                        () => {
                            codeButton.textContent =
                                originalText;
                        },
                        1200
                    );
                } catch {
                    return;
                }
            }
        );
    }
};

const initializeHeaderScroll = () => {
    const header =
        document.querySelector(
            '[data-rino-header]'
        );

    if (!header) {
        return;
    }

    const update = () => {
        if (
            window.scrollY > 10
        ) {
            header.classList.add(
                'bg-rino-surface/80',
                'backdrop-blur-sm',
                'border-rino-border'
            );

            header.classList.remove(
                'bg-transparent',
                'border-transparent'
            );
        } else {
            header.classList.remove(
                'bg-rino-surface/80',
                'backdrop-blur-sm',
                'border-rino-border'
            );

            header.classList.add(
                'bg-transparent',
                'border-transparent'
            );
        }
    };

    update();

    window.addEventListener(
        'scroll',
        update,
        {
            passive: true,
        }
    );
};

const closeDesktopDropdowns = (
    except = null
) => {
    document
        .querySelectorAll(
            '[data-dropdown-menu]'
        )
        .forEach((menu) => {
            if (
                except &&
                menu.dataset.dropdownMenu ===
                    except
            ) {
                return;
            }

            menu.classList.add(
                'invisible',
                'opacity-0',
                'translate-y-1'
            );

            menu.classList.remove(
                'visible',
                'opacity-100',
                'translate-y-0'
            );
        });

    document
        .querySelectorAll(
            '[data-dropdown-trigger]'
        )
        .forEach((trigger) => {
            if (
                except &&
                trigger.dataset
                    .dropdownTrigger ===
                    except
            ) {
                return;
            }

            trigger
                .querySelector(
                    '[data-dropdown-chevron]'
                )
                ?.classList.remove(
                    'rotate-180'
                );
        });
};

const initializeDesktopDropdowns =
    () => {
        document
            .querySelectorAll(
                '[data-dropdown-trigger]'
            )
            .forEach((trigger) => {
                trigger.addEventListener(
                    'click',
                    (event) => {
                        event.preventDefault();
                        event.stopPropagation();

                        const id =
                            trigger.dataset
                                .dropdownTrigger;

                        if (!id) {
                            return;
                        }

                        const menu =
                            document.querySelector(
                                `[data-dropdown-menu="${id}"]`
                            );

                        if (!menu) {
                            return;
                        }

                        const isOpen =
                            menu.classList.contains(
                                'visible'
                            );

                        closeDesktopDropdowns();

                        if (isOpen) {
                            return;
                        }

                        menu.classList.remove(
                            'invisible',
                            'opacity-0',
                            'translate-y-1'
                        );

                        menu.classList.add(
                            'visible',
                            'opacity-100',
                            'translate-y-0'
                        );

                        trigger
                            .querySelector(
                                '[data-dropdown-chevron]'
                            )
                            ?.classList.add(
                                'rotate-180'
                            );
                    }
                );
            });

        document.addEventListener(
            'click',
            (event) => {
                const target =
                    event.target;

                if (
                    !(
                        target instanceof
                        Element
                    )
                ) {
                    return;
                }

                if (
                    target.closest(
                        '[data-header-dropdown]'
                    )
                ) {
                    return;
                }

                closeDesktopDropdowns();
            }
        );

        document.addEventListener(
            'keydown',
            (event) => {
                if (
                    event.key ===
                    'Escape'
                ) {
                    closeDesktopDropdowns();
                }
            }
        );
    };

const closeMobileSubmenus = (
    except = null
) => {
    document
        .querySelectorAll(
            '[data-mobile-dropdown]'
        )
        .forEach((submenu) => {
            if (
                except &&
                submenu.dataset
                    .mobileDropdown ===
                    except
            ) {
                return;
            }

            submenu.classList.remove(
                'max-h-96',
                'opacity-100'
            );

            submenu.classList.add(
                'max-h-0',
                'opacity-0'
            );
        });

    document
        .querySelectorAll(
            '[data-mobile-dropdown-trigger]'
        )
        .forEach((trigger) => {
            if (
                except &&
                trigger.dataset
                    .mobileDropdownTrigger ===
                    except
            ) {
                return;
            }

            trigger
                .querySelector(
                    '[data-mobile-chevron]'
                )
                ?.classList.remove(
                    'rotate-180'
                );
        });
};

const initializeMobileMenu = () => {
    const trigger =
        document.querySelector(
            '[data-mobile-menu-trigger]'
        );

    const menu =
        document.querySelector(
            '[data-mobile-menu]'
        );

    if (!trigger || !menu) {
        return;
    }

    const openIcon =
        trigger.querySelector(
            '[data-mobile-menu-open-icon]'
        );

    const closeIcon =
        trigger.querySelector(
            '[data-mobile-menu-close-icon]'
        );

    let open =
        false;

    const setMenuState = (
        value
    ) => {
        open =
            value;

        if (open) {
            menu.classList.remove(
                'invisible',
                'max-h-0',
                'opacity-0'
            );

            menu.classList.add(
                'visible',
                'max-h-[80vh]',
                'opacity-100'
            );

            openIcon?.classList.add(
                'hidden'
            );

            closeIcon?.classList.remove(
                'hidden'
            );

            trigger.setAttribute(
                'aria-expanded',
                'true'
            );
        } else {
            menu.classList.add(
                'invisible',
                'max-h-0',
                'opacity-0'
            );

            menu.classList.remove(
                'visible',
                'max-h-[80vh]',
                'opacity-100'
            );

            openIcon?.classList.remove(
                'hidden'
            );

            closeIcon?.classList.add(
                'hidden'
            );

            trigger.setAttribute(
                'aria-expanded',
                'false'
            );

            closeMobileSubmenus();
        }
    };

    trigger.setAttribute(
        'aria-expanded',
        'false'
    );

    trigger.addEventListener(
        'click',
        () => {
            setMenuState(
                !open
            );
        }
    );

    document
        .querySelectorAll(
            '[data-mobile-dropdown-trigger]'
        )
        .forEach((button) => {
            button.addEventListener(
                'click',
                () => {
                    const id =
                        button.dataset
                            .mobileDropdownTrigger;

                    if (!id) {
                        return;
                    }

                    const submenu =
                        document.querySelector(
                            `[data-mobile-dropdown="${id}"]`
                        );

                    if (!submenu) {
                        return;
                    }

                    const isOpen =
                        submenu.classList.contains(
                            'max-h-96'
                        );

                    closeMobileSubmenus();

                    if (isOpen) {
                        return;
                    }

                    submenu.classList.remove(
                        'max-h-0',
                        'opacity-0'
                    );

                    submenu.classList.add(
                        'max-h-96',
                        'opacity-100'
                    );

                    button
                        .querySelector(
                            '[data-mobile-chevron]'
                        )
                        ?.classList.add(
                            'rotate-180'
                        );
                }
            );
        });

    menu
        .querySelectorAll('a')
        .forEach((link) => {
            link.addEventListener(
                'click',
                () => {
                    setMenuState(
                        false
                    );
                }
            );
        });

    window.addEventListener(
        'resize',
        () => {
            if (
                window.innerWidth >=
                1024
            ) {
                setMenuState(
                    false
                );
            }
        }
    );
};

const initializeRino = () => {
    initializeThemeState();
    initializeSimpleThemeToggle();
    initializeAnnouncementBar();
    initializeHeaderScroll();
    initializeDesktopDropdowns();
    initializeMobileMenu();

    updateAnnouncementHeight();
};

if (
    document.readyState ===
    'loading'
) {
    document.addEventListener(
        'DOMContentLoaded',
        initializeRino
    );
} else {
    initializeRino();
}