package Auth;

import javax.naming.Context;
import javax.naming.NamingException;
import javax.naming.ldap.InitialLdapContext;
import javax.naming.ldap.LdapContext;
import java.util.Hashtable;

public class LDAPLogin {
    public static Boolean doLogin(String username, String password) {
        String message = null;
        LdapContext ctx = null;

        try {

            Hashtable<String, String> env = new Hashtable<String, String>();
            env.put(Context.INITIAL_CONTEXT_FACTORY, "com.sun.jndi.ldap.LdapCtxFactory");
            env.put(Context.SECURITY_AUTHENTICATION, "Simple");
            env.put(Context.SECURITY_PRINCIPAL, "uid=" + username + ",ou=people,dc=rit,dc=edu");
            env.put(Context.SECURITY_CREDENTIALS, password);
            env.put(Context.PROVIDER_URL, "ldaps://ldap.rit.edu:636");
            env.put(Context.REFERRAL, "follow");
            ctx = new InitialLdapContext(env, null);
            System.out.println("Connected");
            return true;

        } catch (NamingException nex) {
            nex.printStackTrace();
            return false;
        }
    }
}