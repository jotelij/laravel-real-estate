import type { AgentProfile } from "./models";

export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    agent_profile?: AgentProfile;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};
