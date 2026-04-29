export default {
    // ── Auth layout ──────────────────────────────────────────────────
    auth: {
        tagline1: 'Simulate life,',
        tagline2: 'cycle after cycle.',
        inspired: 'Inspired by Conway\'s Game of Life',
        backToHome: 'Back to home',
    },

    // ── Login ─────────────────────────────────────────────────────────
    login: {
        title: 'Log in to your account',
        description: 'Enter your email and password below to log in',
        email: 'Email address',
        password: 'Password',
        forgotPassword: 'Forgot password?',
        remember: 'Remember me',
        submit: 'Log in',
        noAccount: "Don't have an account?",
        signUp: 'Sign up',
        passwordReset: 'Your password has been reset.',
        emailVerified: 'Your email address has been verified.',
    },

    // ── Register ──────────────────────────────────────────────────────
    register: {
        title: 'Create an account',
        description: 'Enter your details below to create your account',
        name: 'Name',
        email: 'Email address',
        password: 'Password',
        confirmPassword: 'Confirm password',
        namePlaceholder: 'Full name',
        submit: 'Create account',
        hasAccount: 'Already have an account?',
        logIn: 'Log in',
    },

    // ── Forgot password ───────────────────────────────────────────────
    forgotPassword: {
        title: 'Forgot password',
        description: 'Enter your email to receive a password reset link',
        email: 'Email address',
        submit: 'Email password reset link',
        returnTo: 'Or, return to',
        logIn: 'log in',
        statusSent: 'A reset link will be sent if the account exists.',
    },

    // ── Reset password ────────────────────────────────────────────────
    resetPassword: {
        title: 'Reset password',
        description: 'Please enter your new password below',
        email: 'Email',
        password: 'Password',
        confirmPassword: 'Confirm Password',
        submit: 'Reset password',
        success: 'Your password has been reset.',
    },

    // ── Confirm password ──────────────────────────────────────────────
    confirmPassword: {
        title: 'Confirm your password',
        description: 'This is a secure area of the application. Please confirm your password before continuing.',
        password: 'Password',
        submit: 'Confirm Password',
    },

    // ── Verify email ──────────────────────────────────────────────────
    verifyEmail: {
        title: 'Verify email',
        description: 'Please verify your email address by clicking on the link we just emailed to you.',
        linkSent: 'A new verification link has been sent to the email address you provided during registration.',
        resend: 'Resend verification email',
        logOut: 'Log out',
    },

    // ── Dashboard ─────────────────────────────────────────────────────
    dashboard: {
        title: 'Dashboard',
        greeting: 'Hello, {name} 👋',
        subtitle: "Here's an overview of your simulations",
        newGame: 'New game',
        savedGames: 'Saved games',
        savedGamesDesc: 'recorded simulations',
        totalCycles: 'Total cycles',
        totalCyclesDesc: 'simulated generations',
        gridSizes: 'Grid sizes',
        gridSizesDesc: 'different sizes used',
        latestSims: 'Latest simulations',
        emptyTitle: 'No simulation found',
        emptyDesc: 'Start a new game to see your saves here.',
        start: 'Start',
        grid: 'Grid {size}×{size}',
        cycles: 'no cycle | 1 cycle | {count} cycles',
    },

    // ── Settings ──────────────────────────────────────────────────────
    settings: {
        title: 'Settings',
        description: 'Manage your profile and account settings',
        nav: {
            profile: 'Profile',
            password: 'Password',
            appearance: 'Appearance',
        },
    },

    // ── Profile settings ──────────────────────────────────────────────
    profile: {
        pageTitle: 'Profile settings',
        sectionTitle: 'Profile information',
        sectionDesc: 'Update your name and email address',
        name: 'Name',
        email: 'Email address',
        namePlaceholder: 'Full name',
        emailPlaceholder: 'Email address',
        unverified: 'Your email address is unverified.',
        resendLink: 'Click here to resend the verification email.',
        linkSent: 'A new verification link has been sent to your email address.',
        save: 'Save',
        saved: 'Saved.',
    },

    // ── Password settings ─────────────────────────────────────────────
    password: {
        pageTitle: 'Password settings',
        sectionTitle: 'Update password',
        sectionDesc: 'Ensure your account is using a long, random password to stay secure',
        current: 'Current password',
        new: 'New password',
        confirm: 'Confirm password',
        save: 'Save password',
        saved: 'Saved',
    },

    // ── Appearance settings ───────────────────────────────────────────
    appearance: {
        pageTitle: 'Appearance settings',
        sectionTitle: 'Appearance settings',
        sectionDesc: "Update your account's appearance settings",
        light: 'Light',
        dark: 'Dark',
        system: 'System',
    },

    // ── Delete account ────────────────────────────────────────────────
    deleteAccount: {
        title: 'Delete account',
        description: 'Delete your account and all of its resources',
        warning: 'Warning',
        warningText: 'Please proceed with caution, this cannot be undone.',
        trigger: 'Delete account',
        dialogTitle: 'Are you sure you want to delete your account?',
        dialogDesc:
            'Once your account is deleted, all of its resources and data will also be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
        password: 'Password',
        cancel: 'Cancel',
        confirm: 'Delete account',
    },

    // ── User menu ─────────────────────────────────────────────────────
    userMenu: {
        settings: 'Settings',
        logOut: 'Log out',
    },

    // ── Sidebar nav ───────────────────────────────────────────────────
    nav: {
        platform: 'Platform',
        dashboard: 'Dashboard',
        githubRepo: 'GitHub Repo',
        documentation: 'Documentation',
    },

    // ── Game controls / Home ──────────────────────────────────────────
    game: {
        title: 'Game of Life',
        cycles: 'Cycles: {count}',
        start: 'Start',
        stop: 'Stop',
        reset: 'Reset',
        save: 'Save',
        savedSuccess: 'Saved successfully',
        gridSize: 'Grid size: {size}',
        speed: 'Speed (ms): {speed}',
        surviveMin: 'Survive Min',
        surviveMax: 'Survive Max',
        birth: 'Birth',
        // controls panel
        controls: 'Controls',
        running: 'Running',
        actions: 'Actions',
        appearance: 'Appearance',
        color: 'Cell Color',
        gridSettings: 'Grid',
        gridSizeLabel: 'Size',
        simSpeed: 'Speed',
        speedLabel: 'Interval',
        rules: 'Rules',
    },

    // ── Language switcher ─────────────────────────────────────────────
    language: {
        label: 'Language',
        en: 'English',
        fr: 'Français',
    },
};
