<script setup>
defineProps({
    stats: {
        type: Object,
        required: true,
    },
    roles: {
        type: Array,
        required: true,
    },
    latestMembers: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <Head title="About">
        <meta name="description" content=" Description Of About" head-key="description">
    </Head>

    <section class="about-page">
        <div class="container">
            <p class="eyebrow">About Us</p>
            <h1>Built around real users, roles, and account activity.</h1>
            <p class="lead">
                This About page is now backed by real application data, giving you a production-safe
                overview of user growth, account health, and role distribution.
            </p>

            <div class="content-grid">
                <article class="card">
                    <h2>User Base</h2>
                    <p>
                        The platform currently has {{ stats.totalUsers }} registered
                        account{{ stats.totalUsers === 1 ? '' : 's' }} available across the system.
                    </p>
                </article>

                <article class="card">
                    <h2>Active Accounts</h2>
                    <p>
                        {{ stats.activeUsers }} user{{ stats.activeUsers === 1 ? '' : 's' }} are marked
                        as active, showing how many accounts are currently usable without intervention.
                    </p>
                </article>

                <article class="card">
                    <h2>Verified Accounts</h2>
                    <p>
                        {{ stats.verifiedUsers }} member{{ stats.verifiedUsers === 1 ? '' : 's' }} have
                        completed email verification and are ready for normal account workflows.
                    </p>
                </article>
            </div>

            <section class="stats-section">
                <div class="stat-box">
                    <strong>{{ stats.totalUsers }}</strong>
                    <span>Total registered members</span>
                </div>
                <div class="stat-box">
                    <strong>{{ stats.rolesCount }}</strong>
                    <span>Distinct roles configured in the user table</span>
                </div>
                <div class="stat-box">
                    <strong>{{ stats.activeUsers }}</strong>
                    <span>Accounts currently marked as active</span>
                </div>
            </section>

            <section class="split-section">
                <div>
                    <p class="section-label">Our Story</p>
                    <h2 class="section-title">The application state tells the story.</h2>
                </div>
                <div class="section-copy">
                    <p>
                        Instead of placeholder marketing content, this page now reflects the current
                        state of your system using real production records from the users table.
                    </p>
                    <p>
                        That makes the About page useful as an operational summary, not just a static
                        description page.
                    </p>
                </div>
            </section>

            <section class="values-section">
                <div class="section-heading">
                    <p class="section-label">Role Breakdown</p>
                    <h2 class="section-title">How your current user access is distributed.</h2>
                </div>

                <div class="values-grid">
                    <article class="card" v-for="role in roles" :key="role.role">
                        <h2>{{ role.role }}</h2>
                        <p>
                            {{ role.total }} account{{ role.total === 1 ? '' : 's' }} currently use the
                            {{ role.role }} permission level.
                        </p>
                    </article>
                </div>
            </section>

            <section class="cta-section">
                <p class="section-label">Latest Members</p>
                <h2 class="section-title">Recently joined users in your application.</h2>
                <div class="member-list">
                    <article class="member-item" v-for="member in latestMembers" :key="member.id">
                        <img :src="member.avatar" :alt="member.name" class="member-avatar">
                        <div>
                            <h3>{{ member.name }}</h3>
                            <p>{{ member.email }}</p>
                            <span>{{ member.role }} • {{ member.status }} • {{ member.created_at }}</span>
                        </div>
                    </article>
                </div>
                <Link :href="route('dashboard')" class="cta-link">Open Dashboard</Link>
            </section>
        </div>
    </section>
</template>

<style scoped>
.about-page {
    padding: 4rem 1.5rem;
    background: #f8fafc;
    min-height: 100vh;
}

.container {
    max-width: 960px;
    margin: 0 auto;
}

.eyebrow {
    margin-bottom: 0.75rem;
    color: #2563eb;
    font-size: 0.9rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

h1 {
    margin: 0 0 1rem;
    color: #0f172a;
    font-size: 2.5rem;
    line-height: 1.1;
}

.lead {
    max-width: 680px;
    margin-bottom: 2rem;
    color: #475569;
    font-size: 1.05rem;
    line-height: 1.7;
}

.content-grid {
    display: grid;
    gap: 1.25rem;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
}

.card {
    padding: 1.5rem;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
}

.card h2 {
    margin: 0 0 0.75rem;
    color: #0f172a;
    font-size: 1.2rem;
}

.card p {
    margin: 0;
    color: #475569;
    line-height: 1.7;
}

.stats-section {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    margin: 3rem 0;
}

.stat-box {
    padding: 1.25rem 1.5rem;
    background: #0f172a;
    border-radius: 16px;
    color: #e2e8f0;
}

.stat-box strong {
    display: block;
    margin-bottom: 0.4rem;
    color: #ffffff;
    font-size: 2rem;
}

.stat-box span {
    line-height: 1.6;
}

.split-section,
.values-section,
.cta-section {
    margin-top: 4rem;
}

.split-section {
    display: grid;
    gap: 2rem;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    align-items: start;
}

.section-label {
    margin: 0 0 0.75rem;
    color: #2563eb;
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.section-title {
    margin: 0;
    color: #0f172a;
    font-size: 2rem;
    line-height: 1.2;
}

.section-copy p {
    margin: 0 0 1rem;
    color: #475569;
    line-height: 1.8;
}

.section-copy p:last-child {
    margin-bottom: 0;
}

.section-heading {
    margin-bottom: 1.5rem;
}

.values-grid {
    display: grid;
    gap: 1.25rem;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
}

.cta-section {
    padding: 2rem;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    border: 1px solid #bfdbfe;
    border-radius: 20px;
}

.cta-copy {
    max-width: 680px;
    margin: 1rem 0 1.5rem;
    color: #334155;
    line-height: 1.8;
}

.member-list {
    display: grid;
    gap: 1rem;
    margin: 1.5rem 0;
}

.member-item {
    display: flex;
    gap: 1rem;
    align-items: center;
    padding: 1rem 1.1rem;
    background: rgba(255, 255, 255, 0.75);
    border: 1px solid #bfdbfe;
    border-radius: 16px;
}

.member-avatar {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    object-fit: cover;
}

.member-item h3 {
    margin: 0 0 0.3rem;
    color: #0f172a;
    font-size: 1rem;
}

.member-item p {
    margin: 0 0 0.2rem;
    color: #334155;
}

.member-item span {
    color: #64748b;
    font-size: 0.9rem;
    text-transform: capitalize;
}

.cta-link {
    display: inline-block;
    padding: 0.85rem 1.25rem;
    background: #2563eb;
    border-radius: 999px;
    color: #ffffff;
    font-weight: 600;
    text-decoration: none;
}
</style>
