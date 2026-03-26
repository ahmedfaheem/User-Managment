<script setup>
defineProps({
    currentUser: {
        type: Object,
        required: true,
    },
    stats: {
        type: Object,
        required: true,
    },
    roleBreakdown: {
        type: Array,
        required: true,
    },
    recentUsers: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <Head title="Home">
        <meta name="description" content="Description Of Home" head-key="description" />
    </Head>

    <section class="home-page">
        <div class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Welcome</p>
                <h1>Build faster with a clean Laravel, Inertia, and Vue workflow.</h1>
                <p class="lead">
                    Your production home page now surfaces real application data from Laravel,
                    including user metrics, account health, and the latest registered members.
                </p>

                <div class="actions">
                    <Link :href="route('dashboard')" class="primary-btn">
                        Open Dashboard
                    </Link>
                    <Link :href="route('about')" class="secondary-btn">
                        Learn More
                    </Link>
                </div>
            </div>

            <div class="hero-panel">
                <p class="panel-label">Signed in as</p>
                <h2>{{ currentUser.name }}</h2>
                <p class="panel-copy">
                    Role: {{ currentUser.role }}
                    <br>
                    Verification:
                    {{ currentUser.verified ? 'Verified account' : 'Verification pending' }}
                    <br>
                    Joined: {{ currentUser.joined_at }}
                </p>
            </div>
        </div>

        <section class="stats-grid">
            <article class="stat-card">
                <strong>{{ stats.totalUsers }}</strong>
                <span>Total registered users</span>
            </article>
            <article class="stat-card">
                <strong>{{ stats.activeUsers }}</strong>
                <span>Active user accounts</span>
            </article>
            <article class="stat-card">
                <strong>{{ stats.unverifiedUsers }}</strong>
                <span>Accounts still pending verification</span>
            </article>
        </section>

        <section class="features-section">
            <div class="section-heading">
                <p class="eyebrow">Role Distribution</p>
                <h2>Current access levels across your production users.</h2>
            </div>

            <div class="features-grid">
                <article class="feature-card" v-for="role in roleBreakdown" :key="role.role">
                    <h3>{{ role.role }}</h3>
                    <p>
                        {{ role.total }} account{{ role.total === 1 ? '' : 's' }} currently assigned to
                        the {{ role.role }} role.
                    </p>
                </article>
            </div>
        </section>

        <section class="activity-section">
            <div class="section-heading">
                <p class="eyebrow">Recent Members</p>
                <h2>The latest users added to your application.</h2>
            </div>

            <div class="activity-list">
                <div class="activity-item" v-for="user in recentUsers" :key="user.id">
                    <span class="activity-dot"></span>
                    <div>
                        <h3>{{ user.name }}</h3>
                        <p>
                            {{ user.email }} • {{ user.role }} • {{ user.status }} • joined
                            {{ user.created_at }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <p class="eyebrow">Account Health</p>
            <h2>Track how many users are active, inactive, and verified.</h2>
            <p class="lead cta-copy">
                Verified users: {{ stats.verifiedUsers }}.
                Inactive users: {{ stats.inactiveUsers }}.
                Use the dashboard for deeper filtering, pagination, and account management.
            </p>
            <Link :href="route('dashboard')" class="primary-btn">
                Go to Dashboard
            </Link>
        </section>
    </section>
</template>

<style scoped>
.home-page {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    padding: 1rem 0 2rem;
}

.hero {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    align-items: stretch;
}

.hero-copy,
.hero-panel,
.feature-card,
.stat-card,
.activity-section,
.cta-section {
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
}

.hero-copy {
    padding: 2rem;
}

.hero-panel {
    padding: 2rem;
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    color: #e2e8f0;
}

.eyebrow {
    margin: 0 0 0.75rem;
    color: #2563eb;
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

h1 {
    margin: 0;
    color: #0f172a;
    font-size: 3rem;
    line-height: 1.1;
}

.lead {
    margin: 1rem 0 0;
    max-width: 720px;
    color: #475569;
    font-size: 1.05rem;
    line-height: 1.8;
}

.actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.75rem;
}

.primary-btn,
.secondary-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.9rem 1.35rem;
    border-radius: 999px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s ease;
}

.primary-btn {
    background: #2563eb;
    color: #ffffff;
}

.primary-btn:hover {
    background: #1d4ed8;
}

.secondary-btn {
    border: 1px solid #cbd5e1;
    color: #0f172a;
    background: #ffffff;
}

.secondary-btn:hover {
    background: #f8fafc;
}

.panel-label {
    margin: 0;
    color: #93c5fd;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.hero-panel h2 {
    margin: 0.75rem 0;
    color: #ffffff;
    font-size: 1.9rem;
}

.panel-copy {
    margin: 0;
    color: #cbd5e1;
    line-height: 1.8;
}

.stats-grid,
.features-grid {
    display: grid;
    gap: 1.25rem;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
}

.stat-card {
    padding: 1.5rem;
}

.stat-card strong {
    display: block;
    margin-bottom: 0.5rem;
    color: #0f172a;
    font-size: 2rem;
}

.stat-card span {
    color: #475569;
    line-height: 1.7;
}

.section-heading h2 {
    margin: 0;
    color: #0f172a;
    font-size: 2rem;
    line-height: 1.2;
}

.features-section {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.feature-card {
    padding: 1.5rem;
}

.feature-card h3,
.activity-item h3 {
    margin: 0 0 0.75rem;
    color: #0f172a;
    font-size: 1.2rem;
    text-transform: capitalize;
}

.feature-card p,
.activity-item p {
    margin: 0;
    color: #475569;
    line-height: 1.8;
}

.activity-section,
.cta-section {
    padding: 2rem;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    margin-top: 1.5rem;
}

.activity-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.activity-dot {
    width: 12px;
    height: 12px;
    margin-top: 0.45rem;
    border-radius: 999px;
    background: #2563eb;
    flex-shrink: 0;
}

.cta-section {
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
}

.cta-copy {
    margin-bottom: 1.5rem;
}

@media (max-width: 640px) {
    h1 {
        font-size: 2.3rem;
    }

    .section-heading h2 {
        font-size: 1.65rem;
    }
}
</style>
