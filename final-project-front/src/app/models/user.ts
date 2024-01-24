import { jwtDecode } from "jwt-decode";

export class User {
    userID: string;
    expirationTime: number;
    email: string;
    firstName: string;
    lastName: string;
    isEmailVerified: boolean;
    token: string;

    constructor(token?: string) {
        this.token = token!;
    }

    public decodeToken() {
        const credentials: any = jwtDecode(this.token);
        this.userID = credentials.id;
        this.expirationTime = credentials.exp;
        this.email = credentials.email;
        this.firstName = credentials.firstName;
        this.lastName = credentials.lastName;
        this.isEmailVerified = typeof(credentials.isEmailVerified) === "string" ? false : true;
    }

    public isTokenActive(): boolean {
        return this.expirationTime > new Date().getTime() / 1000;
    }
}