/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report;

import java.io.File;
import java.io.IOException;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.boris.winrun4j.AbstractService;
import org.boris.winrun4j.Launcher;
import org.boris.winrun4j.Log;
import org.boris.winrun4j.ServiceException;
import org.boris.winrun4j.test.framework.TestHelper;
import th.co.bpg.cde.server.ChangdaoEngine;

/**
 *
 * @author KhaengZai
 */
public class RiceReport extends AbstractService {

    protected ExecutorService threadPool = Executors.newFixedThreadPool(256);

    /**
     * @param args the command line arguments
     * @throws java.lang.Exception
     */
    public static void main(String[] args) throws Exception {
        if (args.length > 0) {
            if ("register".equals(args[0])) {
                register();
            } else if ("unregister".equals(args[0])) {
                unregister();
            }
        } else {
            System.setProperty("java.util.logging.manager", "org.apache.logging.log4j.jul.LogManager");
            ChangdaoEngine.start(args);
        }
    }

    @Override
    public int serviceMain(String[] strings) throws ServiceException {
        try {
            System.setProperty("java.util.logging.manager", "org.apache.logging.log4j.jul.LogManager");
            ChangdaoEngine.start(strings);
            return 0;
        } catch (Exception ex) {
            Logger.getLogger(RiceReport.class.getName()).log(Level.SEVERE, null, ex);
        }
        return 0;
    }

    static void register() throws Exception {
        TestHelper.run(launcher(), "--WinRun4J:RegisterService");
    }

    static void unregister() throws Exception {
        TestHelper.run(launcher(), "--WinRun4J:UnregisterService");
    }

    static Launcher launcher() throws IOException {
        String path = new java.io.File("").getAbsolutePath();
        File temp = new File(path);
        Launcher l = new Launcher(TestHelper.LAUNCHER).
                arg("-this").
                arg("-that").
                vmVersion("1.7", null, null).
                debug(8787, true, false).
                service(RiceReport.class, "RiceReport", "Rice Report By DFT").
                log(new File(temp, "RiceReport.log").toString(), Log.Level.INFO, true, true);
        l.vmarg("-Xcheck:jni");
        TestHelper.testcp(l);
        return l.createAt(new File(temp, "th.go.dft.rice.report.exe"));
    }
}
