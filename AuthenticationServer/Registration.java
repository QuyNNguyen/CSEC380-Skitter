package Auth;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.Random;

public class Registration {

    public static String createSession(String username) {
        String session = generateSessionID();
        try{
            Class.forName("com.mysql.jdbc.Driver");
            Connection con= DriverManager.getConnection(
                    "jdbc:mysql://mysql-db:3306/skitter","root","supersecurepass");
            PreparedStatement stmnt = con.prepareStatement("select count(*) from sessions");
            ResultSet ogSize = stmnt.executeQuery();
            stmnt = con.prepareStatement("select * from sessions where username=?");
            stmnt.setString(1, username);
            ResultSet result = stmnt.executeQuery();
            if(result.isBeforeFirst()) {
                stmnt = con.prepareStatement("replace into sessions values(?,?)");
                stmnt.setString(1, username);
                stmnt.setString(2, session);
                stmnt.executeUpdate();
                return session;
            }else {
                stmnt = con.prepareStatement("insert into sessions values(?,?)");
                stmnt.setString(1, username);
                stmnt.setString(2, session);
                stmnt.executeUpdate();
            }
            stmnt = con.prepareStatement("select count(*) from sessions");
            ResultSet newSize = stmnt.executeQuery();
            ogSize.next();
            newSize.next();
            if(ogSize.getInt(1) < newSize.getInt(1)){
                con.close();
                return session;
            }
            con.close();
        }catch(Exception e) {
            System.out.println(e);
            return "error";
        }
        return "failed";
    }

    public static Boolean verifySession(String session) {
        try{
            Class.forName("com.mysql.jdbc.Driver");
            Connection con= DriverManager.getConnection(
                    "jdbc:mysql://mysql-db:3306/skitter","root","supersecurepass");
            PreparedStatement stmnt = con.prepareStatement("select * from sessions where session_id=?");
            stmnt.setString(1, session);
            ResultSet result = stmnt.executeQuery();
            if(!result.isBeforeFirst()) {
                return false;
            }
            con.close();
            return true;
        }catch(Exception e) {
            System.out.println(e);
            return false;
        }
    }

    protected static String generateSessionID() {
        String dict = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        StringBuilder id = new StringBuilder();
        Random rnd = new Random();
        while (id.length() < 30) {
            int index = (int) (rnd.nextFloat() * dict.length());
            id.append(dict.charAt(index));
        }
        String session_id = id.toString();
        return session_id;
    }
}