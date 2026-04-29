export default {
    // ── Auth layout ──────────────────────────────────────────────────
    auth: {
        tagline1: 'Simulez la vie,',
        tagline2: 'cycle après cycle.',
        inspired: 'Inspiré du jeu de la vie de Conway',
        backToHome: 'Retour à l\'accueil',
    },

    // ── Login ─────────────────────────────────────────────────────────
    login: {
        title: 'Connexion à votre compte',
        description: 'Saisissez votre e-mail et votre mot de passe pour vous connecter',
        email: 'Adresse e-mail',
        password: 'Mot de passe',
        forgotPassword: 'Mot de passe oublié ?',
        remember: 'Se souvenir de moi',
        submit: 'Se connecter',
        noAccount: 'Vous n\'avez pas de compte ?',
        signUp: 'S\'inscrire',
        passwordReset: 'Votre mot de passe a été réinitialisé.',
        emailVerified: 'Votre adresse e-mail a été vérifiée.',
    },

    // ── Register ──────────────────────────────────────────────────────
    register: {
        title: 'Créer un compte',
        description: 'Renseignez vos informations pour créer votre compte',
        name: 'Nom',
        email: 'Adresse e-mail',
        password: 'Mot de passe',
        confirmPassword: 'Confirmer le mot de passe',
        namePlaceholder: 'Nom complet',
        submit: 'Créer un compte',
        hasAccount: 'Vous avez déjà un compte ?',
        logIn: 'Se connecter',
    },

    // ── Forgot password ───────────────────────────────────────────────
    forgotPassword: {
        title: 'Mot de passe oublié',
        description: 'Saisissez votre e-mail pour recevoir un lien de réinitialisation',
        email: 'Adresse e-mail',
        submit: 'Envoyer le lien de réinitialisation',
        returnTo: 'Ou, retourner à la',
        logIn: 'connexion',
        statusSent: 'Un lien de réinitialisation sera envoyé si le compte existe.',
    },

    // ── Reset password ────────────────────────────────────────────────
    resetPassword: {
        title: 'Réinitialiser le mot de passe',
        description: 'Veuillez saisir votre nouveau mot de passe ci-dessous',
        email: 'E-mail',
        password: 'Mot de passe',
        confirmPassword: 'Confirmer le mot de passe',
        submit: 'Réinitialiser le mot de passe',
        success: 'Votre mot de passe a été réinitialisé.',
    },

    // ── Confirm password ──────────────────────────────────────────────
    confirmPassword: {
        title: 'Confirmez votre mot de passe',
        description: 'Il s\'agit d\'une zone sécurisée. Veuillez confirmer votre mot de passe pour continuer.',
        password: 'Mot de passe',
        submit: 'Confirmer le mot de passe',
    },

    // ── Verify email ──────────────────────────────────────────────────
    verifyEmail: {
        title: 'Vérifier l\'e-mail',
        description: 'Veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer.',
        linkSent: 'Un nouveau lien de vérification a été envoyé à l\'adresse e-mail fournie lors de l\'inscription.',
        resend: 'Renvoyer l\'e-mail de vérification',
        logOut: 'Se déconnecter',
    },

    // ── Dashboard ─────────────────────────────────────────────────────
    dashboard: {
        title: 'Tableau de bord',
        greeting: 'Bonjour, {name} 👋',
        subtitle: 'Voici un aperçu de vos simulations',
        newGame: 'Nouvelle partie',
        savedGames: 'Parties sauvegardées',
        savedGamesDesc: 'simulations enregistrées',
        totalCycles: 'Cycles totaux',
        totalCyclesDesc: 'générations simulées',
        gridSizes: 'Tailles de grille',
        gridSizesDesc: 'tailles différentes utilisées',
        latestSims: 'Dernières simulations',
        emptyTitle: 'Aucune simulation trouvée',
        emptyDesc: 'Démarrez une nouvelle partie pour voir vos sauvegardes ici.',
        start: 'Commencer',
        grid: 'Grille {size}×{size}',
        cycles: 'aucun cycle | 1 cycle | {count} cycles',
    },

    // ── Settings ──────────────────────────────────────────────────────
    settings: {
        title: 'Paramètres',
        description: 'Gérez votre profil et les paramètres de votre compte',
        nav: {
            profile: 'Profil',
            password: 'Mot de passe',
            appearance: 'Apparence',
        },
    },

    // ── Profile settings ──────────────────────────────────────────────
    profile: {
        pageTitle: 'Paramètres du profil',
        sectionTitle: 'Informations du profil',
        sectionDesc: 'Mettez à jour votre nom et votre adresse e-mail',
        name: 'Nom',
        email: 'Adresse e-mail',
        namePlaceholder: 'Nom complet',
        emailPlaceholder: 'Adresse e-mail',
        unverified: 'Votre adresse e-mail n\'est pas vérifiée.',
        resendLink: 'Cliquez ici pour renvoyer l\'e-mail de vérification.',
        linkSent: 'Un nouveau lien de vérification a été envoyé à votre adresse e-mail.',
        save: 'Enregistrer',
        saved: 'Enregistré.',
    },

    // ── Password settings ─────────────────────────────────────────────
    password: {
        pageTitle: 'Paramètres du mot de passe',
        sectionTitle: 'Changer le mot de passe',
        sectionDesc: 'Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé',
        current: 'Mot de passe actuel',
        new: 'Nouveau mot de passe',
        confirm: 'Confirmer le mot de passe',
        save: 'Enregistrer le mot de passe',
        saved: 'Enregistré',
    },

    // ── Appearance settings ───────────────────────────────────────────
    appearance: {
        pageTitle: 'Paramètres d\'apparence',
        sectionTitle: 'Paramètres d\'apparence',
        sectionDesc: 'Modifiez les paramètres d\'apparence de votre compte',
        light: 'Clair',
        dark: 'Sombre',
        system: 'Système',
    },

    // ── Delete account ────────────────────────────────────────────────
    deleteAccount: {
        title: 'Supprimer le compte',
        description: 'Supprimez votre compte et toutes ses ressources',
        warning: 'Avertissement',
        warningText: 'Veuillez procéder avec prudence, cette action est irréversible.',
        trigger: 'Supprimer le compte',
        dialogTitle: 'Êtes-vous sûr de vouloir supprimer votre compte ?',
        dialogDesc:
            'Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez saisir votre mot de passe pour confirmer la suppression définitive de votre compte.',
        password: 'Mot de passe',
        cancel: 'Annuler',
        confirm: 'Supprimer le compte',
    },

    // ── User menu ─────────────────────────────────────────────────────
    userMenu: {
        settings: 'Paramètres',
        logOut: 'Se déconnecter',
    },

    // ── Sidebar nav ───────────────────────────────────────────────────
    nav: {
        platform: 'Plateforme',
        dashboard: 'Tableau de bord',
        githubRepo: 'Dépôt GitHub',
        documentation: 'Documentation',
    },

    // ── Game controls / Home ──────────────────────────────────────────
    game: {
        title: 'Jeu de la Vie',
        cycles: 'Cycles : {count}',
        start: 'Démarrer',
        stop: 'Arrêter',
        reset: 'Réinitialiser',
        save: 'Sauvegarder',
        savedSuccess: 'Sauvegarde réussie',
        gridSize: 'Taille de la grille : {size}',
        speed: 'Vitesse (ms) : {speed}',
        surviveMin: 'Survie Min',
        surviveMax: 'Survie Max',
        birth: 'Naissance',
        // panneau de contrôle
        controls: 'Contrôles',
        running: 'En cours',
        actions: 'Actions',
        appearance: 'Apparence',
        color: 'Couleur des cellules',
        gridSettings: 'Grille',
        gridSizeLabel: 'Taille',
        simSpeed: 'Vitesse',
        speedLabel: 'Intervalle',
        rules: 'Règles',
    },

    // ── Language switcher ─────────────────────────────────────────────
    language: {
        label: 'Langue',
        en: 'English',
        fr: 'Français',
    },
};
